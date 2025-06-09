-- Create database
CREATE DATABASE IF NOT EXISTS lamp_test;

-- Use the database
USE lamp_test;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create a user with appropriate permissions
-- Note: Replace 'lamp_password' with a secure password
CREATE USER IF NOT EXISTS 'lamp_user'@'%' IDENTIFIED BY 'lamp_password';
GRANT ALL PRIVILEGES ON lamp_test.* TO 'lamp_user'@'%';
FLUSH PRIVILEGES;

-- Insert sample data (optional)
INSERT INTO users (name, email) VALUES 
('John Doe', 'john@example.com'),
('Jane Smith', 'jane@example.com');