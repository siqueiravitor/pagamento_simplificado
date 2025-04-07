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
            'notify' => $date . '/notify.log',
            default => date('Y-m-d') . '.log'
        };

        $filePath = self::$logDir . $filename;

        $logDir = dirname($filePath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $entry = "[" . date('H:i:s', strtotime('-5 hour')) . "] [$type] $message" . PHP_EOL;
        file_put_contents($filePath, $entry, FILE_APPEND);
    }
}
