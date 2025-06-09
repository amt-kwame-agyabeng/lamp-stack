<?php
// Database configuration
// For local development, use localhost
// For production with RDS, use the RDS endpoint
define('DB_HOST', 'llamp-dev-db.cn8kcow48xsh.eu-west-1.rds.amazonaws.com:3306'); // Change to your RDS endpoint when using AWS
define('DB_USER', 'lamp_user');  // Database username
define('DB_PASS', 'pass123456'); // Database password
define('DB_NAME', 'lamp_test');

// Application settings
define('APP_NAME', 'LAMP Stack Test');
define('APP_VERSION', '1.0.0');

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Session start
session_start();
?>