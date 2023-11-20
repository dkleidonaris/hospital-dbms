<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
$PAGE_TITLE = "Contact us";

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include($_SERVER['DOCUMENT_ROOT'] . "/../includes/mail.php");
    $mail->From = "site@hospital.odeit.gr";
    $mail->FromName = "Hospital DBMS";
    $mail->addAddress("dkleidonaris@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = "Contact Form";
    $mail->Body = "<body><span>Subject: " . $_POST['name'] . "</body>";
    $mail->AltBody = "This is the plain text version of the email content";

    if (!$mail->send()) {
        header("Location: contact.php/?message=Mailer Error: " . http_build_query(["message" => $mail->ErrorInfo]));
    } else {
        header("Location: contact.php/?" . http_build_query(["message" => "Your message was successfully sent"]));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/message.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <div class="flex justify-center p-2 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="px-2 flex flex-col justify-center p-2 mx-auto">
                <table>
                    <tr>
                        <td class="p-2">
                            <label for="name">Your Name: </label>
                        </td>
                        <td class="p-2">
                            <input name="name" type="text" placeholder="Enter your name" required="required" class="h-8 md:w-80 leading-8 indent-1 border-2 border-black rounded-md">
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2">
                            <label for="email">Your Email: </label>
                        </td>
                        <td class="p-2">
                            <input name="email" type="text" placeholder="email@example.com" required="required" class="h-8 md:w-80 leading-8 indent-1 border-2 border-black rounded-md">
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2">
                            <label for="message">Your Message: </label>
                        </td>
                        <td class="p-2">
                            <textarea name="message" rows="10" cols="25" class="pl-2 border-2 border-black rounded-md resize"></textarea>
                        </td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Submit Form" class="p-2 rounded-md bg-gray-200 hover:bg-gray-300">
            </div>
        </form>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>