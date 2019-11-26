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


$router->with('/?', function () use ($router, $twig) {
    $router->get("/", function () use ($twig) {
        return $twig->render('public_index.twig');
    });
});

$router->dispatch();