<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
