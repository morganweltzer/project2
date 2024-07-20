<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve POST data
$username = $_POST["username"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$phone = $_POST["phone"];

// Check if all required fields are set
if (isset($username) && isset($password) && isset($firstname) && isset($lastname) && isset($email) && isset($phone)) {
    // Attempt to add new user
    if (addnewuser($username, $password, $firstname, $lastname, $email, $phone)) {
        echo "Registration Successful";
    } else {
        echo "Registration failed";
    }
} else {
    echo "All fields are required";
}

function addnewuser($username, $password, $firstname, $lastname, $email, $phone) {
    // Database connection
    $mysqli = new mysqli('localhost', 'weltzeme', '1234', 'waph');

    // Check connection
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }

    // Prepare SQL statement
    $prepared_sql = "INSERT INTO users (username, password, firstname, lastname, email, phone) VALUES (?, md5(?), ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($prepared_sql);

    if (!$stmt) {
        printf("SQL statement preparation failed: %s\n", $mysqli->error);
        return FALSE;
    }

    // Bind parameters
    $stmt->bind_param("ssssss", $username, $password, $firstname, $lastname, $email, $phone);

    // Execute statement
    if ($stmt->execute()) {
        return TRUE;
    } else {
        printf("Execution failed: %s\n", $stmt->error);
        return FALSE;
    }
}
?>
