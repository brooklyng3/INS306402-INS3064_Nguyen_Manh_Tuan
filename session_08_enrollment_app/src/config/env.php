<?php
// config/env.php

// Toggle this between 'development' and 'production'
define('ENVIRONMENT', 'production'); 

// Set a unified log file location for both environments
$logFile = __DIR__ . '/../logs/php_error.log';
ini_set('log_errors', 1);
ini_set('error_log', $logFile);

if (ENVIRONMENT === 'development') {
    // DEV: Show all errors on the screen
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // PROD: Hide errors from the screen completely
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}