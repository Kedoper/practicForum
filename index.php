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
    $router->get("/", function () use ($twig) {
        return $twig->render('public_index.twig', [
            'userLogged' => isLoggedUser(),
            'threadsData' => callAPI('threads', 'get')
        ]);
    });

    $router->get("/thread/[i:id]", function ($req) use ($twig) {
        $thread_id = $req->id;
        return $twig->render('public_thread.twig', [
            'userLogged' => isLoggedUser(),
            'threadData' => callAPI('threads', 'getbyid', ['thread_id' => $thread_id])
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
    $router->get("/login", function () use ($twig) {
        return $twig->render('template_authPage.twig', [
            'action' => 'login'
        ]);
    });
    $router->get("/register", function () use ($twig) {
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

$router->dispatch();