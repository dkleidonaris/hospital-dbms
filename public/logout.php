<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Logout";

$_SESSION = array();
session_destroy();

session_start();

$_SESSION['message_type'] = 'info';
$_SESSION['message'] = 'You have logged out!';
header("Location: login.php");
exit;
