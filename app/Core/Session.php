<?php

namespace App\Core;

class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public static function forget(string $key): void {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, $value): void {
        self::set('__flash_' . $key, $value);
    }

    public static function getFlash(string $key) {
        $value = $_SESSION['__flash_' . $key] ?? null;
        unset($_SESSION['__flash_' . $key]);
        return $value;
    }

    public static function destroy(): void {
        session_destroy();
    }
}
