<?php
// Set page title
$pageTitle = "LAMP Stack Test Application";

// Include header
include_once 'includes/header.php';
?>

<div class="container mt-5">
    <div class="jumbotron">
        <h1>LAMP Stack Test Application</h1>
        <p class="lead">Use this application to test your LAMP infrastructure</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Server Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Server Name:</strong> <?php echo $_SERVER['SERVER_NAME']; ?></p>
                    <p><strong>Server IP:</strong> <?php echo $_SERVER['SERVER_ADDR']; ?></p>
                    <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
                    <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
                    <a href="phpinfo.php" class="btn btn-info">View Full PHP Info</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Database Connection</h5>
                </div>
                <div class="card-body">
                    <?php include_once 'includes/db_status.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">User Management (Database CRUD Test)</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h5>Add New User</h5>
                            <form action="includes/process_user.php" method="post">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                                </div>
                                <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <h5>User List</h5>
                            <?php include_once 'includes/list_users.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>