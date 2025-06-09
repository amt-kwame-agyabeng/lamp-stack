<?php
// Include configuration
require_once 'includes/config.php';

// Display header
require_once 'includes/header.php';

// Connect to database (works for both local MySQL and RDS)
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<div class='alert alert-success'>Successfully connected to MySQL server at " . DB_HOST . "</div>";
    
    // Select database
    if ($conn->select_db(DB_NAME)) {
        echo "<div class='alert alert-success'>Database '" . DB_NAME . "' selected successfully</div>";
    } else {
        echo "<div class='alert alert-warning'>Database '" . DB_NAME . "' does not exist. Creating it now...</div>";
        
        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Database created successfully</div>";
            $conn->select_db(DB_NAME);
        } else {
            throw new Exception("Error creating database: " . $conn->error);
        }
    }
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Table 'users' created or already exists</div>";
    } else {
        throw new Exception("Error creating table: " . $conn->error);
    }
    
    // Check if table is empty
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        echo "<div class='alert alert-info'>Adding sample data to users table...</div>";
        
        // Insert sample data
        $sql = "INSERT INTO users (name, email) VALUES 
            ('John Doe', 'john@example.com'),
            ('Jane Smith', 'jane@example.com')";
            
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Sample data added successfully</div>";
        } else {
            throw new Exception("Error adding sample data: " . $conn->error);
        }
    } else {
        echo "<div class='alert alert-info'>Users table already contains data</div>";
    }
    
    echo "<div class='alert alert-success'>Database setup completed successfully!</div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}

// Close connection if open
if (isset($conn) && $conn) {
    $conn->close();
}

// Display footer
require_once 'includes/footer.php';
?>