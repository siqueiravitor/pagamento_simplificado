<?php

namespace App\Core;

class Cli {
    public static function handle(array $argv): void {
        $command = $argv[1] ?? null;
        $name = $argv[2] ?? null;

        if ($command === 'migrate') {
            self::runMigrations();
        }elseif ($command === 'make:migration' && $name) {
            self::makeMigration($name);
        } elseif ($command === 'make:controller' && $name) {
            self::makeController($name);
        } elseif ($command === 'make:model' && $name) {
            self::makeModel($name);
        } else {
            echo "\nComando inválido ou não informado.\nEx: php cli make:model Produto\n";
        }
    }

    private static function makeModel(string $name): void {
        $class = ucfirst($name);
        $filename = __DIR__ . '/../Models/' . $class . 'Model.php';
        $namespace = 'App\\Models';
        $table = strtolower($class) . 's';

        if (file_exists($filename)) {
            echo "\nModel {$class}Model já existe!\n";
            return;
        }

        $template = <<<PHP
<?php

namespace $namespace;

use App\Core\Model;

class {$class}Model extends Model {
    protected string \$table = '$table';
}
PHP;

        file_put_contents($filename, $template);
        echo "\nModel {$class}Model criado com sucesso em app/Models\n";
    }

    private static function makeController(string $name): void {
        $class = ucfirst($name);
        $filename = __DIR__ . '/../Controllers/' . $class . 'Controller.php';
        $namespace = 'App\\Controllers';

        if (file_exists($filename)) {
            echo "\nController {$class}Controller já existe!\n";
            return;
        }

        $template = <<<PHP
<?php

namespace $namespace;

class {$class}Controller {
    public function index(): void {
        echo "{$class}Controller funcionando!";
    }
}
PHP;

        file_put_contents($filename, $template);
        echo "\nController {$class}Controller criado com sucesso em app/Controllers\n";
    }
    private static function makeMigration(string $name): void {
        $timestamp = date('YmdHis');
        $snakeName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        $filename = __DIR__ . '/../../database/migrations/' . $timestamp . '_' . $snakeName . '.php';
    
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
    
        if (file_exists($filename)) {
            echo "\nMigration já existe: {$filename}\n";
            return;
        }
    
        $template = <<<PHP
    <?php
    
    return function(mysqli \$db) {
        // \$db->query("CREATE TABLE example (id INT AUTO_INCREMENT PRIMARY KEY)");
    };
    PHP;
    
        file_put_contents($filename, $template);
        echo "\nMigration criada: {$filename}\n";
    }
    private static function runMigrations(): void {
        $path = __DIR__ . '/../../database/migrations/';
        if (!is_dir($path)) {
            echo "\nNenhuma pasta de migrações encontrada.\n";
            return;
        }
    
        $files = glob($path . '*.php');
        if (empty($files)) {
            echo "\nNenhuma migration encontrada.\n";
            return;
        }
    
        $db = \App\Core\Database::connection();
    
        foreach ($files as $file) {
            echo "Executando: " . basename($file) . "\n";
            $migration = require $file;
            if (is_callable($migration)) {
                $migration($db);
            } else {
                echo "Migration inválida: {$file}\n";
            }
        }
    
        echo "\nTodas as migrations foram executadas.\n";
    }
    
}
