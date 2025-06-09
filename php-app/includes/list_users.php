<?php
// Include database functions
require_once 'db_functions.php';

// Get all users
$users = getAllUsers();

// Display users in a table
if (count($users) > 0) {
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Name</th>';
    echo '<th>Email</th>';
    echo '<th>Created</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($user['id']) . '</td>';
        echo '<td>' . htmlspecialchars($user['name']) . '</td>';
        echo '<td>' . htmlspecialchars($user['email']) . '</td>';
        echo '<td>' . htmlspecialchars($user['created_at']) . '</td>';
        echo '<td>';
        echo '<form action="includes/process_user.php" method="post" style="display:inline;">';
        echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';
        echo '<button type="submit" name="delete_user" class="btn btn-sm btn-danger">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="alert alert-info">No users found. Add a user to test database functionality.</div>';
}
?>