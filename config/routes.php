<?php
/**
 * Route configuration
 * URL => [Controller, method]
 */

return [
    '/' => ['App\\Controllers\\HomeController', 'index'],
    '/health' => ['App\\Controllers\\HomeController', 'health'],
];
