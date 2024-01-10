<?php
$_SERVER['DOCUMENT_ROOT'] . "/../config.php";

try {
    $dbh = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
    echo "\n" . "There was a problem connecting to the database: " . $e->getMessage() . "\n";
}
