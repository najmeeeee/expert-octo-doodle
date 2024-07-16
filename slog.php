<?php
session_start();
if(session_destroy()) {
    if (isset($_COOKIE['login_user'])) {
        setcookie("login_user", "", time() - 3600, "/"); // Clear the cookie
    }
    if (isset($_COOKIE['login_admin'])) {
        setcookie("login_admin", "", time() - 3600, "/"); // Clear the cookie
    }
    header("Location: s2.php");
    exit(); // Ensure script termination after redirection
}
?>
