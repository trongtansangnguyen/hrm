<?php
/**
 * HRM Application Entry Point
 */

// Load configuration
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/autoload.php';

// Session configuration
session_set_cookie_params([
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// CSRF token generator
if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

// CSRF token verifier
if (!function_exists('verify_csrf')) {
    function verify_csrf($token) {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
    }
}

// Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$routes = include __DIR__ . '/../config/routes.php';

if (isset($routes[$uri])) {
    list($controller_class, $method) = $routes[$uri];
    try {
        $controller = new $controller_class();
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            http_response_code(404);
            echo 'Method not found';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
        error_log($e->getMessage());
    }
} else {
    http_response_code(404);
    echo '404 Not Found';
}
