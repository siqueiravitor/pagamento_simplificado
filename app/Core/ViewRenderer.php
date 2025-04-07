<?php

namespace App\Core;

class ViewRenderer {
    public static function render(string $view, array $data = []): void {
        $path = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($path)) {
            extract($data);
            require $path;
        } else {
            http_response_code(500);
            echo "View '{$view}' não encontrada.";
        }
    }
}
