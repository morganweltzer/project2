<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require('authentication.php');
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] != TRUE) {
    session_destroy();
    header("Location: userlogin.php");
    exit();
}
session_start();



if (!isset($_SESSION['userId'])) {
    header("Location: userlogin.php");
    exit();
}

$userId = $_SESSION['userId'] ?? $_COOKIE['userId'];

//database
$mysqli = new mysqli('localhost', 'admin', '1234', 'weltzeme');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

$prepared_sql = "SELECT username, firstname, lastname, email, phone FROM users WHERE id=?";
$stmt = $mysqli->prepare($prepared_sql);
if (!$stmt) {
    printf("SQL statement preparation failed: %s\n", $mysqli->error);
    exit();
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$mysqli->close();

if (!$user) {
    echo "User not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .profile-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .profile-container p {
            margin-bottom: 10px;
            color: #555;
        }
        .profile-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #6a64f1;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
        }
        .profile-container button:hover {
            background-color: #5a54d1;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Hi <?php echo htmlspecialchars($user['firstname']); ?>!</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    
    <a href="usereditprofile.php" class="button">Edit Profile</a>
    <a href="logoutuser.php" class="button">Logout</a>
</div>

</body>
</html>
