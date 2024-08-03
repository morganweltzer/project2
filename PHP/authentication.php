<?php
$lifetime = 15*60;
$path = "/";
$domain = "";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
session_start();

if (!isset($_SESSION['authenticated']) or $_SESSION['authenticated'] != TRUE) {
    session_destroy();
    echo "<script>alert('Log in Please!')</script>";
    header("Refresh: 0; url=registrationform.php");
    die();
}

if ($_SESSION['browser'] != $_SERVER['HTTP_USER_AGENT']) {
    echo "<script>alert('Session hijacking');</script>";
    header("Refresh: 0; url=registrationform.php");
    die();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

function generate_csrf_token() {
    return bin2hex(openssl_random_pseudo_bytes(16));
}

if (!isset($_SESSION["nocsrftoken"])) {
    $_SESSION["nocsrftoken"] = generate_csrf_token();
}
?>
