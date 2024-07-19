<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <title>WAPH-Login page</title>
</head>
<body>
<?php
?>
  <!-- <form action="addnewuser.php" method="POST" class="form login">
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password: <input type="password" class="text_field" name="password" /> <br>
    <button class="button" type="submit">Login</button>
  </form> -->
</body>
</html>

<div class="formbold-main-wrapper">
  <!-- Open source registration form template by FormBold -->
  <!-- Author: FormBold Team -->
  <!-- Learn More: https://formbold.com -->
  <div class="formbold-form-wrapper">
    <!-- <form action="https://formbold.com/s/FORM_ID" method="POST"> -->
      <form action="addnewuser.php" method="POST">
      <div class="formbold-form-title">
        <h2 class="">Register now</h2>
        <p>
          Enter Your Information in the Form Below to Create an Account
        </p>
      </div>

      <div class="formbold-input-flex">
        <div>
          <label for="firstname" class="formbold-form-label">
            First name
          </label>
          <input
            type="text"
            name="firstname"
            id="firstname"
            class="formbold-form-input"
          />
        </div>
        <div>
          <label for="lastname" class="formbold-form-label"> Last name </label>
          <input
            type="text"
            name="lastname"
            id="lastname"
            class="formbold-form-input"
          />
        </div>
      </div>

      <div class="formbold-input-flex">
        <div>
          <label for="email" class="formbold-form-label"> Email </label>
          <input
            type="email"
            name="email"
            id="email"
            class="formbold-form-input"
          />
        </div>
        <div>
          <label for="phone" class="formbold-form-label"> Phone number </label>
          <input
            type="text"
            name="phone"
            id="phone"
            class="formbold-form-input"
          />
        </div>
      </div>

      <div class="formbold-mb-3">
        <label for="username" class="formbold-form-label">
          Username
        </label>
        <input
          type="text"
          name="username"
          id="username"
          class="formbold-form-input"
        />
      </div>

      <div class="formbold-mb-3">
        <label for="password" class="formbold-form-label">
          Password
        </label>
        <input
          type="text"
          name="password"
          id="password"
          class="formbold-form-input"
        />
      </div>
      <button class="formbold-btn">Register Now</button>
    </form>
  </div>
</div>
