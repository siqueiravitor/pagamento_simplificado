<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;
use App\Core\ResponseHelper;
use App\Controllers\Web\AuthController;
use App\Controllers\Api\TransferController;

Session::start();

$router = new Router();

$router->get('/', [AuthController::class, 'index']);
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->group('/api', function($router) {
    $router->post('/transfer', [TransferController::class, 'handle']);
});


$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

$dispatched = $router->dispatch($method, $uri);
if (!$dispatched) {
    ResponseHelper::error(404, 'Rota não encontrada');
}
