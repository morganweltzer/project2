<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();


// Function to sanitize user inputs
function input_sanitization($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Function to authenticate user
function authenticate_user($username, $password) {
    $mysqli = new mysqli('localhost', 'admin', '1234', 'weltzeme');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }

    $prepared_sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf("SQL statement preparation failed: %s\n", $mysqli->error);
        return FALSE;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $mysqli->close();

    if ($user && password_verify($password, $user['password'])) {
        return $user['id'];
    } else {
        return FALSE;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = input_sanitization($_POST["username"]);
    $password = input_sanitization($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $userId = authenticate_user($username, $password);

        if ($userId) {
            // Set session and cookies on successful login
            $_SESSION['userId'] = $userId;
            $_SESSION['authenticated'] = TRUE;
            $_SESSION['browser'] = $_SERVER['HTTP_USER_AGENT'];
            setcookie("userId", $userId, time() + (86400 * 30), "/"); // Cookie expires in 30 days
            header("Location: welcome.php"); // Redirect to welcome page
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        $error_message = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <form action="userlogin.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="registrationform.php">Register here</a></p>
</div>
</body>
</html>
