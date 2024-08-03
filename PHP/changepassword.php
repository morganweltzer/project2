<?php
require('session_auth.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $token = $_POST["nocsrftoken"];

    if (!isset($token) or ($token != $_SESSION["nocsrftoken"])) {
        echo "CSRF Attack detected.";
        die();
    }
    unset($_SESSION["nocsrftoken"]);
    
    if (empty($current_password) || empty($new_password)) {
        echo "All fields are required.";
        exit();
    }

    $mysqli = new mysqli('localhost', 'team_user', 'team_password', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT password FROM users WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (md5($current_password) != $hashed_password) {
        echo "Current password is incorrect.";
        exit();
    }

    $new_hashed_password = md5($new_password);
    $sql = "UPDATE users SET password=? WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $new_hashed_password, $username);

    if ($stmt->execute()) {
        echo "<script>alert('Password changed successfully!');window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error updating password');window.location='index.php';</script>";
    }
    $stmt->close();
    $mysqli->close();
}
?>
