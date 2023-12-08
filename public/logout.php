<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Logout";

$_SESSION = array();
session_destroy();

header("Location: login.php");
exit;
