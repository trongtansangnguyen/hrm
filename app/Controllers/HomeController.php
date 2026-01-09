<?php
/**
 * Home Controller
 */

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        header('Content-Type: text/html; charset=utf-8');
        echo '<h1>HRM System - Chào mừng!</h1>';
        echo '<p>Phiên bản v1.0.0</p>';
        echo '<p><a href="/health">/health</a></p>';
    }

    public function health()
    {
        header('Content-Type: application/json');
        
        require __DIR__ . '/../../config/config.php';
        
        try {
            $pdo = new \PDO($dsn, $DB_USER, $DB_PASS);
            $pdo->query('SELECT 1');
            http_response_code(200);
            echo json_encode(['status' => 'OK', 'db' => 'connected']);
        } catch (\Throwable $e) {
            http_response_code(503);
            echo json_encode(['status' => 'FAIL', 'db' => 'disconnected', 'error' => $e->getMessage()]);
        }
    }
}
