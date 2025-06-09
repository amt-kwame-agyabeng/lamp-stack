<?php
// Include database functions
require_once 'db_functions.php';

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Add user
    if (isset($_POST['add_user'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        
        // Validate input
        if (empty($name) || empty($email)) {
            $_SESSION['error'] = "Name and email are required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format";
        } else {
            // Add user to database
            $result = addUser($name, $email);
            
            if ($result['status']) {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }
        }
    }
    
    // Delete user
    if (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];
        
        // Delete user from database
        $result = deleteUser($user_id);
        
        if ($result['status']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
    }
    
    // Redirect back to index page
    header("Location: ../index.php");
    exit();
}
?>