<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";
include_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');

ob_start();
session_status() === PHP_SESSION_ACTIVE ?: session_start();
