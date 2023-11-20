<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
$sql_files = ['db_create.sql', 'data.sql'];

foreach ($sql_files as $file) {
    if (file_exists(__DIR__ . "/sql/" . $file)) {
        $sql = file_get_contents(__DIR__ . "/sql/" . $file);
    } else {
        echo "<b>The following sql seed file does not exist: " . $file . "</b>";
        die();
    }

    try {
        $dbh->exec($sql);
    } catch (PDOException $e) {
        echo "<b>" . $e->getMessage() . "</b>";
    }
}
