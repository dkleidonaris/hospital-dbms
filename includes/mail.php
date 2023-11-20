<?php
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "hospital.odeit.gr";
    $mail->SMTPAuth = true;
    $mail->Username = "site@hospital.odeit.gr";
    $mail->Password = "oopCc_bd%dZ;";
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;