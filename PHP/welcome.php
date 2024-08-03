<?php 
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  require('authentication.php');
  if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] != TRUE) {
      session_destroy();
      header("Location: userlogin.php");
      exit();
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  <title>Welcome Page</title>
</head>
<body>
  <div class="container">
    <h1>Welcome User</h1>
    <a href="editprofile.php">Edit Profile</a>
    <a href="logoutuser.php">Logout</a>
  </div>
</body>
</html>
