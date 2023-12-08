<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Appointments";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-doctor.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>
    <div class="my-4 flex flex-col gap-4 max-w-3xl mx-auto">
        <div class="flex gap-2 items-center">
            <label for="appointment_date" class="text-xl font-bold">Select a date:</label>
            <input id="date_input" type="date" class="p-2 rounded-md">
        </div>
        <div id="appointments_div" class="px-4 flex flex-col gap-4 max-w-3xl mx-auto">

        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
    <script>
        $('#date_input').change(function() {
            $.ajax({
                url: "/api/appointments.php",
                data: {
                    'scope': 'doctor',
                    'doctor_id': <?php echo $_SESSION['doctor_id'] ?>,
                    'appointment_date': $('#date_input').val()
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    console.log(data);
                    data.results.forEach(function(item, i) {
                        $('#appointments_div').append('<div id="appointment-' + (i + 1) + '" class="p-2 shadow-md rounded-md border-2 border-black"></div>');
                        $('#appointment-' + (i + 1)).append('<p class="text-xl font-bold">' + item.Date + '</p>');
                        $('#appointment-' + (i + 1)).append('<p class="ml-4">' + item.LastName + ' ' + item.FirstName + '</p>');
                    });
                }
            });
        });
    </script>
</body>

</html>