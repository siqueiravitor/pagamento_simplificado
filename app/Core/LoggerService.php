<?php
namespace App\Core;

class LoggerService {
    private static string $logDir = __DIR__ . '/../../storage/logs/';

    public static function log(string $type, string $message): void {
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }

        $date = date('Y-m-d');
        $filename = match (strtolower($type)) {
            'api' => $date . '/api.log',
            'auth' => $date . '/auth.log',
            'error' => $date . '/error.log',
            default => date('Y-m-d') . '.log'
        };

        $file = self::$logDir . $filename;
        $entry = "[" . date('H:i:s') . "] [$type] $message" . PHP_EOL;
        file_put_contents($file, $entry, FILE_APPEND);
    }
}
