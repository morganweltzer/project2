<?php

$lifetime = 15 * 60;
$path = "/";
$domain = "";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirm_password']));

    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($username) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $mysqli = new mysqli('localhost', 'admin', '1234', 'weltzeme');
        if ($mysqli->connect_errno) {
            $error = "Database connection failed: " . $mysqli->connect_error;
        } else {
            $stmt = $mysqli->prepare("INSERT INTO users (firstname, lastname, email, phone, username, password) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                $error = "SQL statement preparation failed: " . $mysqli->error;
            } else {
                $stmt->bind_param("ssssss", $firstname, $lastname, $email, $phone, $username, $hashedPassword);
                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $error = "Registration failed: " . $stmt->error;
                }
                $stmt->close();
            }
            $mysqli->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>WAPH-Register</title>
    <style>
        .formbold-form-input {
            width: 100%;
            padding: 8px;
            margin: 4px 0 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .formbold-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .formbold-btn:hover {
            background-color: #0056b3;
        }
        .formbold-link-btn {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .formbold-link-btn:hover {
            background-color: #5a6268;
        }
        #passwordHint {
            color: red;
            display: none;
        }
    </style>
</head>
<body>

<div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="formbold-form-title">
                <h2>Register now</h2>
                <p>Enter Your Information in the Form Below to Create an Account</p>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="firstname" class="formbold-form-label">First name</label>
                    <input type="text" name="firstname" id="firstname" class="formbold-form-input" required />
                </div>
                <div>
                    <label for="lastname" class="formbold-form-label">Last name</label>
                    <input type="text" name="lastname" id="lastname" class="formbold-form-input" required />
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="email" class="formbold-form-label">Email</label>
                    <input type="email" name="email" id="email" class="formbold-form-input" required />
                </div>
                <div>
                    <label for="phone" class="formbold-form-label">Phone number</label>
                    <input type="text" name="phone" id="phone" class="formbold-form-input" required />
                </div>
            </div>

            <div class="formbold-mb-3">
                <label for="username" class="formbold-form-label">Username</label>
                <input type="text" name="username" id="username" class="formbold-form-input" required />
            </div>

            <div class="formbold-mb-3">
                <label for="password" class="formbold-form-label">Password</label>
                <input type="password" name="password" id="password" class="formbold-form-input" required />
            </div>

            <div class="formbold-mb-3">
                <label for="confirm_password" class="formbold-form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="formbold-form-input" required />
                <p id="passwordHint">Passwords do not match.</p>
            </div>

            <button type="submit" class="formbold-btn">Register Now</button>
        </form>
        <a href="userlogin.php" class="formbold-link-btn">Already have an account? Login here</a>
    </div>
</div>

<script>
    function validateForm() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        var hint = document.getElementById('passwordHint');

        if (password !== confirmPassword) {
            hint.style.display = 'block';
            return false;
        }
         else {
            hint.style.display = 'none';
        }

        return true;
    }

    window.onload = function() {
        <?php if (isset($success) && $success === true): ?>
            alert('Registration successful!');
        <?php elseif (isset($error)): ?>
            alert('Error: <?php echo $error; ?>');
        <?php endif; ?>
    };
</script>

</body>
</html>
