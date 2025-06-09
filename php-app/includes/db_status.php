<?php
// Include configuration file
require_once 'config.php';

// Test database connection
function testDatabaseConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($conn->connect_error) {
            return [
                'status' => false,
                'message' => "Connection failed: " . $conn->connect_error
            ];
        }
        
        // Get server info
        $server_info = $conn->server_info;
        $host_info = $conn->host_info;
        
        // Close connection
        $conn->close();
        
        return [
            'status' => true,
            'message' => "Connected successfully",
            'server_info' => $server_info,
            'host_info' => $host_info
        ];
    } catch (Exception $e) {
        return [
            'status' => false,
            'message' => "Connection error: " . $e->getMessage()
        ];
    }
}

// Get connection status
$db_status = testDatabaseConnection();

// Display connection status
if ($db_status['status']) {
    echo '<div class="alert alert-success">';
    echo '<h5>Connection Successful!</h5>';
    echo '<p><strong>MySQL Server:</strong> ' . htmlspecialchars($db_status['server_info']) . '</p>';
    echo '<p><strong>Host Info:</strong> ' . htmlspecialchars($db_status['host_info']) . '</p>';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger">';
    echo '<h5>Connection Failed!</h5>';
    echo '<p>' . htmlspecialchars($db_status['message']) . '</p>';
    echo '<p>Please check your database configuration in includes/config.php</p>';
    echo '</div>';
}
?>