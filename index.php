<?php declare(strict_types=1);
include './config/db.php';
include './vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
	$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

$router->group('user', function (\League\Route\RouteGroup $route) {
	$route->map('GET', 'login', [Controllers\LoginController::class, 'index']);

	$route->map('POST', 'login', [Controllers\LoginController::class, 'login']);

	$route->map('GET', 'logout', [Controllers\LoginController::class, 'logout']);
});

$router->group('task', function (\League\Route\RouteGroup $route) {
	$route->map('GET', 'add', [Controllers\TaskController::class, 'add']);

	$route->map('POST', 'create', [Controllers\TaskController::class, 'create']);

	$route->map('GET', '{id}/edit', [Controllers\TaskController::class, 'edit'])
		->middleware(new \Core\Middleware());

	$route->map('POST', '{id}/update', [Controllers\TaskController::class, 'update'])
		->middleware(new \Core\Middleware());

	$route->map('GET', '{id}/completed', [Controllers\TaskController::class, 'completed'])
		->middleware(new \Core\Middleware());
});
// map a route
$router->map('GET', '/', [Controllers\MainController::class, 'index']);
$router->map('GET', '/page/{id}', [Controllers\MainController::class, 'page']);
try{
	$response = $router->dispatch($request);
}catch (Exception $exception){
	$response = new Laminas\Diactoros\Response('php://memory', 404);
	$response->getBody()->write('<h1>404</h1>');
}

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);