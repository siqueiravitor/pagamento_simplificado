<?php

namespace App\Middlewares;

use App\Core\LoggerService;
use App\Core\ResponseHelper;

class ApiMiddleware {
    private string $validToken;

    public function __construct() {
        $config = require __DIR__ . '/../../config/tokenMiddleware.php';
        $this->validToken = $config['API_TOKEN'] ?? '123';
    }

    public function handle($method, $uri, $params): void {
        $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!str_starts_with($auth, 'Bearer ')) {
            LoggerService::log('api', "Token ausente na requisição {$method} {$uri}");
            ResponseHelper::error(401, 'Token ausente');
        }

        $token = trim(str_replace('Bearer', '', $auth));
        if ($token !== $this->validToken) {
            LoggerService::log('api', "Token inválido usado na rota {$uri}");
            ResponseHelper::error(403, 'Token inválido');
        }
    }
}
