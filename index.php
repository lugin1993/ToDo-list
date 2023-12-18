<?php
declare(strict_types=1);
include './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
	$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

$router->group('user', function (\League\Route\RouteGroup $route) {
	$route->map('GET', 'login', [App\Controllers\LoginController::class, 'index']);

	$route->map('POST', 'login', [App\Controllers\LoginController::class, 'login']);

	$route->map('GET', 'logout', [App\Controllers\LoginController::class, 'logout']);
});

$router->group('task', function (\League\Route\RouteGroup $route) {
	$route->map('GET', 'add', [App\Controllers\TaskController::class, 'add']);

	$route->map('POST', 'create', [App\Controllers\TaskController::class, 'create']);

	$route->map('GET', '{id}/edit', [App\Controllers\TaskController::class, 'edit'])
		->middleware(new App\Core\Middleware());

	$route->map('POST', '{id}/update', [App\Controllers\TaskController::class, 'update'])
		->middleware(new App\Core\Middleware());

	$route->map('GET', '{id}/completed', [App\Controllers\TaskController::class, 'completed'])
		->middleware(new App\Core\Middleware());
});

$router->map('GET', '/', [App\Controllers\MainController::class, 'index']);
$router->map('GET', '/page/{id}', [App\Controllers\MainController::class, 'page']);
try{
	$response = $router->dispatch($request);
}catch (Exception $exception){
	$response = new Laminas\Diactoros\Response('php://memory', 404);
	$response->getBody()->write('<h1>404</h1>');
}

(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);