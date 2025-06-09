<?php
// Database configuration
define('DB_HOST', 'localhost'); // Change to your database server IP or hostname
define('DB_USER', 'lamp_user');  // Change to your database username
define('DB_PASS', 'lamp_password'); // Change to your database password
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