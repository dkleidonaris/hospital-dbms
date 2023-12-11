<nav>
    <div class="grid md:grid-cols-3 justify-center bg-orange-200 py-2">
        <div class="mb-2 md:mb-0">
            <a href="/"><img src="/assets/img/logo_full.png" width="600" height="100" class="h-16 w-auto mx-auto object-contain"></a>
        </div>
        <div class="md:col-span-2 flex flex-row gap-8 items-center">
            <a class="text-center md:text-2xl hover:text-blue-500" href="/">Home</a>
            <a class="text-center md:text-2xl hover:text-blue-500" href="/book-appointment.php">Book an appointment</a>
            <a class="text-center md:text-2xl hover:text-blue-500" href="/contact.php">Contact</a>
            <a class="ml-auto mr-8 text-center md:text-2xl hover:text-blue-500" href="/login.php">Login</a>

        </div>
    </div>
    <?php
    if (isset($_SESSION['message_type'], $_SESSION['message'])) {
        include($_SERVER["DOCUMENT_ROOT"] . "/includes/message.inc.php");
    }
    unset($_SESSION["message_type"]);
    unset($_SESSION["message"]);
    ?>
</nav>