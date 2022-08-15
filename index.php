<?php
use App\Core\Router;

require_once 'app/modules/debug.php';
require_once 'config.php';
spl_autoload_register(function ($class){
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});


session_start();
$router = new Router();
?>