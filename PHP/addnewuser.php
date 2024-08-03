<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($username) || empty($password)) {
        $error = "All fields are required.";
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
                // Bind parameters and execute
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
                <p id="passwordHint" style="color: red; display: none;">Password must be at least 8 characters long and contain at least one number and one special character.</p>
            </div>
            <button type="submit" class="formbold-btn">Register Now</button>
        </form>
    </div>
</div>

<script>
    function validateForm() {
        var password = document.getElementById('password').value;
        var hint = document.getElementById('passwordHint');
        var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!regex.test(password)) {
            hint.style.display = 'block';
            return false;
        } else {
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
