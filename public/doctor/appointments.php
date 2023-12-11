<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/doctor.php");

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
    <div class="my-4 px-4 flex flex-col gap-4">
        <div class="flex gap-2 justify-center items-center">
            <label for="appointment_date" class="text-xl font-bold">Select a date:</label>
            <input id="date_input" type="date" class="p-2 rounded-md">
        </div>
        <div id="appointments_div" class="relative overflow-x-auto border-2 border-gray-300 rounded-md max-w-3xl mx-auto px-2 hidden">
            <div class="flex justify-center gap-2 my-2 text-xl">
                <p>Appointments for:</p>
                <p id="first_name" class="font-bold"></p>
                <p id="last_name" class="font-bold"></p>
                <p>|</p>
                <p id="date">|</p>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            TIME
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Patient Name
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
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

                    $('#first_name').html('<?php echo $_SESSION['first_name']; ?>');
                    $('#last_name').html('<?php echo $_SESSION['last_name']; ?>');
                    var date = new Date($('#date_input').val());
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    };
                    $('#date').html(date.toLocaleDateString('en-GR', options));

                    $('#tbody').html('');
                    if (data.results.length) {
                        data.results.forEach(function(item, i) {
                            $('#tbody').append('<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><th scope="row" class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap">' + item.Date + '</th><td class="px-6 py-4 font-bold text-base text-black">' + item.LastName + ' ' + item.FirstName + '</td></tr>');
                        });
                    } else {
                        $('#tbody').html('<p class="m-4 text-center text-base text-black">There are no booked appointments for the date that you selected!</p>');
                    }

                    $('#appointments_div').removeClass('hidden');
                }
            });
        });
    </script>
</body>

</html>