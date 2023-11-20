<?php
include('beginScripts.php');

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'dbms');

try {
    $dbh = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
    echo "\n" . "There was a problem connecting to the database: " . $e->getMessage() . "\n";
}
