<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Page</title>
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
    .container {
      text-align: center;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .container h1 {
      margin-bottom: 20px;
    }
    .container a {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      text-decoration: none;
      color: #fff;
      background-color: #007BFF;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    .container a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome User</h1>
    <a href="editprofile.php">Edit Profile</a>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
