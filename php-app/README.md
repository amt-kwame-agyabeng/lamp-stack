# LAMP Stack Test Application

A simple PHP application to test your LAMP (Linux, Apache, MySQL, PHP) infrastructure.

## Features

- Server information display
- Database connection testing
- User management (CRUD operations)
- Simple, responsive Bootstrap interface

## Installation

1. Copy all files to your web server's document root (e.g., `/var/www/html/`)
2. Configure your database settings in `includes/config.php`
3. Access the application through your web browser
4. Run the setup page first: `http://your-server/setup.php`

## Configuration

Edit the `includes/config.php` file to set your database connection parameters:

```php
// Database configuration
define('DB_HOST', 'localhost'); // Change to your database server IP or hostname
define('DB_USER', 'lamp_user');  // Change to your database username
define('DB_PASS', 'lamp_password'); // Change to your database password
define('DB_NAME', 'lamp_test');
```

## MySQL Setup

If you need to create a MySQL user for this application:

```sql
CREATE DATABASE lamp_test;
CREATE USER 'lamp_user'@'%' IDENTIFIED BY 'lamp_password';
GRANT ALL PRIVILEGES ON lamp_test.* TO 'lamp_user'@'%';
FLUSH PRIVILEGES;
```

## Testing Your Infrastructure

This application helps you test:

1. **Web Server**: Verifies Apache is running and PHP is properly configured
2. **Database Server**: Tests MySQL connectivity and CRUD operations
3. **Network**: Confirms communication between web and database servers

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache 2.4 or higher
- Internet connection (for Bootstrap CDN)