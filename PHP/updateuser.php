<?php
require('authentication.php');

session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

// Database
$mysqli = new mysqli('localhost', 'admin', '1234', 'weltzeme');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

$firstname = $mysqli->real_escape_string($_POST['firstname']);
$lastname = $mysqli->real_escape_string($_POST['lastname']);
$email = $mysqli->real_escape_string($_POST['email']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$username = $mysqli->real_escape_string($_POST['username']);
$password = isset($_POST['password']) ? $_POST['password'] : '';


if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "UPDATE users SET firstname=?, lastname=?, email=?, phone=?, username=?, password=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $phone, $username, $hashedPassword, $userId);
} else {
    $sql = "UPDATE users SET firstname=?, lastname=?, email=?, phone=?, username=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $phone, $username, $userId);
}

if (!$stmt) {
    printf("SQL statement preparation failed: %s\n", $mysqli->error);
    exit();
}

if ($stmt->execute()) {
    header("Location: profilepage.php");
    exit();
} else {
    printf("Profile update failed: %s\n", $stmt->error);
}

$stmt->close();
$mysqli->close();
?>
