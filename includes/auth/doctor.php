<?php
if (!isset($_SESSION['type'])) {
    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'Please login to access this page!';
    header('Location: /login.php');
    exit;
} else {
    if ($_SESSION['type'] != 'doctor') {
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Login with doctor credentials to access this page!';

        $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
        header('Location: /login.php');
        exit;
    }
}
