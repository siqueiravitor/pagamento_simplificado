<?php
namespace App\Middlewares;

use App\Core\ResponseHelper;

class AuthMiddleware {
    public function handle($method, $uri, $params) {
        if (!isset($_SESSION['user'])) {
            ResponseHelper::error(401, 'Não autorizado');
        }
    }
}
