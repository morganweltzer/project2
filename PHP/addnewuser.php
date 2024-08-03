<?php

function input_sanitization($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function addnewuser($username, $password, $firstname, $lastname, $email, $phone) {
    $mysqli = new mysqli('localhost', 'admin', '1234', 'weltzeme');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }

    $prepared_sql = "INSERT INTO users (username, password, firstname, lastname, email, phone) VALUES (?, md5(?), ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($prepared_sql);

    if (!$stmt) {
        printf("SQL statement preparation failed: %s\n", $mysqli->error);
        return FALSE;
    }
    $stmt->bind_param("ssssss", $username, $password, $firstname, $lastname, $email, $phone);
    if ($stmt->execute()) {
        return TRUE;
    } else {
        printf("Execution failed: %s\n", $stmt->error);
        return FALSE;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    //protecting against xss attack

    $username = input_sanitization($username);
    $password = input_sanitization($password);
    $firstname = input_sanitization($firstname);
    $lastname = input_sanitization($lastname);
    $email = input_sanitization($email);
    $phone = input_sanitization($phone);

    //check to make sure all fields are entered & add user

    if (isset($username) && isset($password) && isset($firstname) && isset($lastname) && isset($email) && isset($phone)) {
    if (addnewuser($username, $password, $firstname, $lastname, $email, $phone)) {
        echo "Registration Successful";
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
            exit();
    } else {
        echo "Registration failed";
    }
} else {
    echo "All fields are required";
}

}

?>
