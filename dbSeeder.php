<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
$sql_files = scandir($_SERVER['DOCUMENT_ROOT'] . "/../sql");

foreach ($sql_files as $file) {
    $path_info = pathinfo(__DIR__ . "/sql/" . $file);
    if ($path_info['extension'] == 'sql') {
        $sql = file_get_contents(__DIR__ . "/sql/" . $file);

        try {
            $dbh->exec($sql);
        } catch (PDOException $e) {
            echo "<b>" . $e->getMessage() . "</b>";
        }
    }
    
}
