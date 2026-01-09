<?php
/**
 * Application configuration
 */

// Database
$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_NAME = getenv('DB_NAME') ?: 'hrm';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

// PDO options
$pdo_options = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
];

// App
$APP_NAME = getenv('APP_NAME') ?: 'HRM System';
$APP_VERSION = getenv('APP_VERSION') ?: '1.0.0';

// Log
$LOG_DIR = __DIR__ . '/../logs';
$LOG_FILE = $LOG_DIR . '/app_' . date('Y-m-d') . '.log';
