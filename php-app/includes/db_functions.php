<?php
// Include configuration file
require_once 'config.php';

// Function to get database connection
function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Function to initialize the database and create tables if they don't exist
function initializeDatabase() {
    try {
        // Try to connect to the database
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
        
        // Check connection
        if ($conn->connect_error) {
            return [
                'status' => false,
                'message' => "Connection failed: " . $conn->connect_error
            ];
        }
        
        // Create database if it doesn't exist
        $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        if ($conn->query($sql) !== TRUE) {
            return [
                'status' => false,
                'message' => "Error creating database: " . $conn->error
            ];
        }
        
        // Select the database
        $conn->select_db(DB_NAME);
        
        // Create users table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($sql) !== TRUE) {
            return [
                'status' => false,
                'message' => "Error creating table: " . $conn->error
            ];
        }
        
        // Close connection
        $conn->close();
        
        return [
            'status' => true,
            'message' => "Database initialized successfully"
        ];
    } catch (Exception $e) {
        return [
            'status' => false,
            'message' => "Database initialization error: " . $e->getMessage()
        ];
    }
}

// Function to add a new user
function addUser($name, $email) {
    $conn = getDbConnection();
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    
    // Execute statement
    $result = $stmt->execute();
    
    // Check for errors
    if (!$result) {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return [
            'status' => false,
            'message' => "Error adding user: " . $error
        ];
    }
    
    // Get inserted ID
    $id = $stmt->insert_id;
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
    
    return [
        'status' => true,
        'message' => "User added successfully",
        'id' => $id
    ];
}

// Function to get all users
function getAllUsers() {
    $conn = getDbConnection();
    
    // Query to get all users
    $sql = "SELECT * FROM users ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    $users = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    
    $conn->close();
    
    return $users;
}

// Function to delete a user
function deleteUser($id) {
    $conn = getDbConnection();
    
    // Prepare statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute statement
    $result = $stmt->execute();
    
    // Check for errors
    if (!$result) {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return [
            'status' => false,
            'message' => "Error deleting user: " . $error
        ];
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
    
    return [
        'status' => true,
        'message' => "User deleted successfully"
    ];
}

// Initialize database on first load
$init_result = initializeDatabase();
if (!$init_result['status']) {
    echo '<div class="alert alert-danger">' . $init_result['message'] . '</div>';
}
?>