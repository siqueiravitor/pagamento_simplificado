<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Api\TransferController;
use App\Controllers\Web\UserController;
use App\Core\ResponseHelper;
use App\Core\Router;
use App\Core\Session;
use App\Controllers\Web\AuthController;
use App\Middlewares\ApiMiddleware;
use App\Middlewares\AuthMiddleware;

Session::start();

$router = new Router();

$router->get('/', [AuthController::class, 'index']);
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->group('/api', function($router) {
    $router->post('/transfer', [TransferController::class, 'handle']);
}, [new ApiMiddleware(), 'handle']);

$router->group('', function($router) {
    $router->get('/dashboard', [UserController::class, 'index']);
    $router->post('/transfer', [UserController::class, 'transfer']);
    $router->post('/deposit', [UserController::class, 'deposit']);
}, [new AuthMiddleware(), 'handle']);


$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

$dispatched = $router->dispatch($method, $uri);
if (!$dispatched) {
    ResponseHelper::error(404, 'Rota não encontrada');
}
