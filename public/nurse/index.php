<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/nurse.php");


// $stmt = $dbh->prepare('INSERT INTO User VALUES(:email, :password, :type, :nurse_id, :doctor_id)');
// $stmt->execute([':email' => 'w@w.com', ':password' => password_hash("123", PASSWORD_DEFAULT), ':type' => 'nurse', ':doctor_id' => null, ':nurse_id' => 1]);

$PAGE_TITLE = "Doctor Dashboard";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-doctor.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <div class="flex justify-center gap-2 max-w-3xl mx-auto">
        <a href="/doctor/appointments.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2 ">
                <img src="/assets/img/appointment.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">My appointments</p>

            </div>
        </a>
        <a href="/doctor/patient.php">
            <div class="p-2 flex flex-col justify-center items-center shadow-md rounded-xl hover:bg-blue-300 border-2">
                <img src="/assets/img/patient_tab.png" width="200" height="20" alt="">
                <p class="text-xl font-bold">Patient Tab</p>

            </div>
        </a>
    </div>


    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>

</body>

</html>