<?php
if (!isset($_SESSION['type'])) {
    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'Please login to access this page!';
    header('Location: /login.php');
    exit;
} else {
    if ($_SESSION['type'] != 'nurse') {
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Login with nurse credentials to access this page!';
        
        header('Location: /login.php');
        exit;
    }
}
