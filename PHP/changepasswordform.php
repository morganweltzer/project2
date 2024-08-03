<?php
require "session_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Change Password</h2>
            <form action="changepassword.php" method="POST">
                <div class="form-group">
                    <label>Username:</label>
                    <span><?php echo htmlentities($_SESSION['username']) ?></span>
                </div>
                <div class="form-group">
                    <label>Current Password:</label>
                    <input type="password" class="form-control" required name="current_password" />
                </div>
                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$" name="new_password" title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE" />
                </div>
                <input type="hidden" name="nocsrftoken" value="<?php echo $_SESSION['nocsrftoken']; ?>"/>
                <button class="btn btn-primary" type="submit">Change Password</button>
                <a href="index.php" class="btn btn-secondary">Home</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
