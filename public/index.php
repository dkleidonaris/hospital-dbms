<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
$PAGE_TITLE = "Home";


$dbh->exec("CREATE TABLE `Department` (
    `ID` integer PRIMARY KEY AUTO_INCREMENT,
    `Name` varchar(255)
  );
        INSERT INTO `Department` (`Name`) VALUES
        ('Cardiology'),
        ('Neurology'),
        ('Oncology'),
        ('Pediatrics'),
        ('Orthopedics'),
        ('Dermatology'),
        ('Gastroenterology'),
        ('Urology'),
        ('Emergency Medicine'),
        ('Endocrinology');

  CREATE TABLE `Employee` (
    `ID` integer PRIMARY KEY AUTO_INCREMENT,
    `email` varchar(255) UNIQUE,
    `password` varchar(255),
    `firstName` varchar(255),
    `lastName` varchar(255),
    `type` varchar(255),
    `departmentID` integer,
    `contactNumber` varchar(255)
  );");
$stmt = $dbh->prepare('INSERT INTO Employee (email, password, firstName, lastName, type, departmentID, contactNumber) VALUES(:email, :password, :first_name, :last_name, :type, :department_id, :contact_number)');
$stmt->execute([':email' => 'd@d.com', ':password' => password_hash("123", PASSWORD_DEFAULT), ':first_name' => 'Alice', ':last_name' => 'Hamilton',  ':type' => 'doctor', ':department_id' => 1, ':contact_number' => '69453636']);
$stmt->execute([':email' => 'n@n.com', ':password' => password_hash("123", PASSWORD_DEFAULT), ':first_name' => 'John', ':last_name' => 'Morrison',  ':type' => 'nurse', ':department_id' => null, ':contact_number' => '69453635367']);
$stmt->execute([':email' => 's@s.com', ':password' => password_hash("123", PASSWORD_DEFAULT), ':first_name' => 'George', ':last_name' => 'Jackson',  ':type' => 'secreatary', ':department_id' => null, ':contact_number' => '69453696579']);
include($_SERVER['DOCUMENT_ROOT'] . "/../dbSeeder.php");

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>