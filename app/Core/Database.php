<?php

namespace App\Core;

use mysqli;

class Database {
    private static ?mysqli $connection = null;

    public static function connection(): mysqli {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../../config/database.php';

            self::$connection = new mysqli(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['dbname'],
                $config['port']
            );

            if (self::$connection->connect_error) {
                die("Erro ao conectar ao banco de dados: " . self::$connection->connect_error);
            }

            self::$connection->set_charset($config['charset']);
        }

        return self::$connection;
    }
}
