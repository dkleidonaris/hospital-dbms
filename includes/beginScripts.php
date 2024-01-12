<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";
include_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');

ob_start();
session_status() === PHP_SESSION_ACTIVE ?: session_start();

if ($_SERVER['REQUEST_URI'] != '/login.php' && $_SERVER['REQUEST_URI'] != '/404.php' && !strpos($_SERVER['REQUEST_URI'], 'api')) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
}