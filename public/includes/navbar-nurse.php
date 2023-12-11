<nav>
    <div class="grid md:grid-cols-3 justify-center bg-orange-200 py-2">
        <div class="mb-2 md:mb-0">
            <a href="/"><img src="/assets/img/logo_full.png" width="600" height="100" class="h-16 w-auto mx-auto object-contain"></a>
        </div>
        <div class="md:col-span-2 flex flex-row gap-8 items-center">
        <a class="text-center md:text-2xl hover:text-blue-500" href="/doctor/index.php">Dashboard</a>
            <a class="text-center md:text-2xl hover:text-blue-500" href="/doctor/appointments.php">Appointments</a>
            <a class="text-center md:text-2xl hover:text-blue-500" href="/doctor/patient.php">Patient Tab</a>
            <div class="ml-auto pl-10 mr-8 flex gap-1 items-center">
                <p class="md:text-xl italic">Hello Nurse</p>
                <p class="font-bold italic md:text-xl"><?php echo $_SESSION['last_name']?></p>
                <p>|</p>
                <a href="/logout.php" class="md:text-xl text-blue-600">Logout</a>
            </div>
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