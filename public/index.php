<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../dbSeeder.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
//include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
$PAGE_TITLE = "Home";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php"); ?>
    <div>
        <img src="/assets/img/home_slide.jpg" width="1920" height="1080" class="max-w-screen h-screen object-cover" alt="">
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>