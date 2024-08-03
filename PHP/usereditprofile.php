<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start(); 
if (!isset($_SESSION['userId'])) {
    header("Location: userlogin.php");
    exit();
}


$userId = $_SESSION['userId']; 
$mysqli = new mysqli('localhost', 'admin', '1234', 'weltzeme');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

$sql = "SELECT username, firstname, lastname, email, phone FROM users WHERE id=?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    printf("SQL statement preparation failed: %s\n", $mysqli->error);
    exit();
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <title>Edit Profile</title>

</head>
<body>

<div class="formbold-main-wrapper">
  <div class="formbold-form-wrapper">
    <form action="updateuser.php" method="POST">
      <div class="formbold-form-title">
        <h2>Edit Profile</h2>
        <p>Update Your Information Below</p>
      </div>

      <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userId); ?>">

      <div class="formbold-input-flex">
        <div>
          <label for="firstname" class="formbold-form-label">First name</label>
          <input
            type="text"
            name="firstname"
            id="firstname"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($user['firstname']); ?>"
            required
          />
        </div>
        <div>
          <label for="lastname" class="formbold-form-label">Last name</label>
          <input
            type="text"
            name="lastname"
            id="lastname"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($user['lastname']); ?>"
            required
          />
        </div>
      </div>

      <div class="formbold-input-flex">
        <div>
          <label for="email" class="formbold-form-label">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($user['email']); ?>"
            required
          />
        </div>
        <div>
          <label for="phone" class="formbold-form-label">Phone number</label>
          <input
            type="text"
            name="phone"
            id="phone"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($user['phone']); ?>"
            required
          />
        </div>
      </div>

      <div class="formbold-mb-3">
        <label for="username" class="formbold-form-label">Username</label>
        <input
          type="text"
          name="username"
          id="username"
          class="formbold-form-input"
          value="<?php echo htmlspecialchars($user['username']); ?>"
          required
        />
      </div>

      <div class="formbold-mb-3">
        <label for="password" class="formbold-form-label">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          class="formbold-form-input"
        />
        <p>Leave blank if you don't want to change the password</p>
      </div>

      <button class="formbold-btn">Update Profile</button>
    </form>
  </div>
</div>

</body>
</html>
