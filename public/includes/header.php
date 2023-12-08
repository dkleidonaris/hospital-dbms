<?php
if (isset($_SESSION['message_type'], $_SESSION['message'])) {
    include($_SERVER["DOCUMENT_ROOT"] . "/includes/message.inc.php");
}
unset($_SESSION["message_type"]);
unset($_SESSION["message"]);
?>

<h1 class="py-2 text-3xl text-center"><?php echo $PAGE_TITLE; ?></h1>