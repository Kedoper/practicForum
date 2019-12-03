<?php

include './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$loader = new \Twig\Loader\FilesystemLoader(['./templates', './public']);
$twig = new \Twig\Environment($loader, [
//    'cache' => '/path/to/compilation_cache',
]);

if (boolval(getenv("DEBUG"))) {
    $whoops = new \Whoops\Run;
    $whoops
        ->prependHandler(new \Whoops\Handler\PrettyPageHandler)
        ->register();
}

include './libs/rb/connect.php';

$router = new \Klein\Klein();


function isLoggedUser(): bool
{
    if (!empty($_SESSION['logged_user'])) {
        return true;
    }
    return false;
}

function getUserSessionData(): array
{
    return $_SESSION['logged_user'] ? $_SESSION['logged_user'] : [];
}

function updateUserSession(): void
{
    if (isLoggedUser()) {
        $_SESSION['logged_user'] = R::load('users', $_SESSION['logged_user']['id'])->export();
    }
}

function updateThreadStats($thread_id): void
{
    $userView = json_decode($_COOKIE['threads'], true) ? json_decode($_COOKIE['threads'], true) : [];
    if (!in_array($thread_id, $userView)) {
        callAPI('threads', 'statsup', ['thread_id' => $thread_id]);
        $userView[] = $thread_id;
    }
    setcookie('threads', json_encode($userView));
}

function renderErrorPage(int $code): void
{
    global $twig;
    global $router;
    $router->response()->code(404);
    $router->response()->body($twig->render("error404.twig", [
        'userLogged' => isLoggedUser(),
        'userData' => getUserSessionData(),
    ]));
}


function callAPI(string $section, string $method, ?array $params = []): array
{
    $host = $_SERVER['HTTP_HOST'];
    $curl = curl_init("http://$host/api/$section.$method");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    return json_decode($response, true);
}


$router->with('/?', function () use ($router, $twig) {
    $router->get("*", 'updateUserSession');

    $router->get("/", function () use ($twig) {
        return $twig->render('public_index.twig', [
            'userLogged' => isLoggedUser(),
            'userData' => getUserSessionData(),
            'threadsData' => callAPI('threads', 'get')
        ]);
    });

    $router->get("/thread/[i:id]", function ($req) use ($twig, $router) {
        $thread_id = $req->id;
        updateThreadStats($thread_id);
        $thread = callAPI('threads', 'getbyid', ['thread_id' => $thread_id]);
        if (empty($thread)) {
            return renderErrorPage(404);
        }
        return $twig->render('public_thread.twig', [
            'userLogged' => isLoggedUser(),
            'userData' => getUserSessionData(),
            'threadData' => $thread
        ]);
    });

    $router->get("/thread/new", function () use ($twig) {
        return $twig->render('public_create_thread.twig', [
            'userLogged' => isLoggedUser(),
            'userData' => getUserSessionData(),
        ]);
    });

    $router->get("/logout", function () use ($router) {
        session_destroy();
        $router->response()->redirect('/');
    });
});


$router->with('/auth/?', function () use ($router, $twig) {
    $router->get("/*", function () use ($router) {
        $router->response()->redirect("/auth/login");
    });
    $router->get("/login", function () use ($twig, $router) {
        if (isLoggedUser()) $router->response()->redirect("/");
        return $twig->render('template_authPage.twig', [
            'action' => 'login'
        ]);
    });
    $router->get("/register", function () use ($twig, $router) {
        if (isLoggedUser()) $router->response()->redirect("/");
        return $twig->render('template_authPage.twig', [
            'action' => 'register'
        ]);
    });
});

$router->respond(['GET', 'POST'], '/api/[*:section].[*:method]', function ($req) use ($router) {
    $section = $req->section;
    $method = $req->method;
    if (file_exists("./api/$section/$method.php")) {
        include_once "./api/$section/$method.php";
    } else {
        echo json_encode([]);
    }
});

$router->onHttpError(function () use ($twig) {
    renderErrorPage(404);
});

$router->dispatch();