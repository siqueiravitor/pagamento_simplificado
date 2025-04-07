<?php

namespace App\Core;

class ResponseHelper {
    public static function wantsJson(): bool {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        return str_contains($accept, 'application/json') || str_starts_with($uri, '/api');
    }

    public static function error(int $code, string $message): void {
        http_response_code($code);
        if (self::wantsJson()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $message]);
        } else {
            echo "<h1>{$code} - {$message}</h1>";
        }
        exit;
    }

    public static function success(array $data = [], int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
