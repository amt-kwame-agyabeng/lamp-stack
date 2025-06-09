<?php
// Set page title
$pageTitle = "Database Setup";

// Include header
include_once 'includes/header.php';

// Include database functions
require_once 'includes/db_functions.php';

// Initialize database
$init_result = initializeDatabase();
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Database Setup</h2>
        </div>
        <div class="card-body">
            <?php if ($init_result['status']): ?>
                <div class="alert alert-success">
                    <h4>Database Setup Successful!</h4>
                    <p><?php echo $init_result['message']; ?></p>
                    <p>The following has been created:</p>
                    <ul>
                        <li>Database: <strong><?php echo DB_NAME; ?></strong></li>
                        <li>Table: <strong>users</strong> (id, name, email, created_at)</li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <h4>Database Setup Failed!</h4>
                    <p><?php echo $init_result['message']; ?></p>
                    <p>Please check your database configuration in includes/config.php</p>
                </div>
            <?php endif; ?>
            
            <h3 class="mt-4">Database Configuration</h3>
            <p>Current database configuration:</p>
            <ul>
                <li>Host: <strong><?php echo DB_HOST; ?></strong></li>
                <li>User: <strong><?php echo DB_USER; ?></strong></li>
                <li>Password: <strong>[Hidden]</strong></li>
                <li>Database Name: <strong><?php echo DB_NAME; ?></strong></li>
            </ul>
            
            <p class="mt-4">To change the database configuration, edit the file: <code>includes/config.php</code></p>
            
            <div class="mt-4">
                <a href="index.php" class="btn btn-primary">Go to Homepage</a>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>