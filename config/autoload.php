<?php
/**
 * Auto-loader for app classes
 * PSR-4 style: App\ClassName -> app/ClassName.php
 */

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    
    if (strpos($class, $prefix) !== 0) {
        return;
    }
    
    $relative_class = substr($class, strlen($prefix));
    $base_dir = __DIR__ . '/../app/';
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
