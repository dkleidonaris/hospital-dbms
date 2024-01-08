<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");


// $stmt = $dbh->prepare('INSERT INTO User VALUES(:email, :password, :type, :nurse_id, :doctor_id)');
// $stmt->execute([':email' => 'w@w.com', ':password' => password_hash("123", PASSWORD_DEFAULT), ':type' => 'nurse', ':doctor_id' => null, ':nurse_id' => 1]);

$PAGE_TITLE = "Secretary Dashboard";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-secretary.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <div class="flex justify-center gap-2 mx-auto">
        <a href="/secretary/departments/index.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2">
                <img src="/assets/img/department.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">Departments</p>
            </div>
        </a>
        <a href="/secretary/rooms/index.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2">
                <img src="/assets/img/room.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">Rooms</p>
            </div>
        </a>
        <a href="/secretary/employees/index.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2">
                <img src="/assets/img/employee.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">Employees</p>
            </div>
        </a>
        <a href="/secretary/patients/index.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2 ">
                <img src="/assets/img/patient.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">Patients</p>

            </div>
        </a>
        <a href="/secretary/admissions/index.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2 ">
                <img src="/assets/img/admission.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">Admissions</p>

            </div>
        </a>
    </div>


    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>

</body>

</html>