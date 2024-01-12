<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/doctor.php");

$PAGE_TITLE = "Edit Medication";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $dbh->prepare('SELECT * from Medication M WHERE ID=?');
        $stmt->execute(array($_GET['id']));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() < 1) {
            die("No Medication with the given ID");
        } else {
            if($result['DoctorID'] != $_SESSION['employee_id']) {
                die("You don't have permission to edit this! Contact the prescribing doctor: ");
            }
        }
    } else {
        die('You haven\'t provided the id for editing!');
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $dbh->prepare('UPDATE Medication SET Name=?, Dosage=?, Frequency=?, StartDate=?, EndDate=?, OtherDescription=? WHERE ID=?');
    $stmt->debugDumpParams();

    $stmt->execute([$_POST['med_name'], $_POST['dosage'], $_POST['frequency'], $_POST['start_date'], $_POST['end_date'], $_POST['description'], $_POST['med_id']]);
    $stmt->debugDumpParams();

    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'Your changes have been saved!';
    header('Location: /doctor/patient.php?insurance_id=' . $_POST['patient_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-secretary.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>


    <form class="max-w-md mx-auto" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input name="patient_id" value="<?php echo $result['PatientID']?>" type="text" class="hidden">
        <div class="my-4 flex items-center gap-2">
            <label for="med_id" class="min-w-36">Medication ID:</label>
            <input name="med_id" id="patient" value="<?php echo $_GET['id']; ?>" type="text" class="w-full  text-gray-700 bg-gray-400 rounded-md p-2 flex-1" readonly>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="med_name" class="min-w-36">Medication Name:</label>
            <input name="med_name" value="<?php echo $result['Name']; ?>" id="med_name" type="text" class="flex-1 rounded-md p-2">
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="dosage" class="min-w-36">Dosage</label>
            <input name="dosage" value="<?php echo $result['Dosage']; ?>" id="dosage" type="text" class="flex-1 rounded-md p-2">
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="frequency" class="min-w-36">Frequency:</label>
            <input name="frequency" value="<?php echo $result['Frequency']; ?>" id="frequency" type="text" class="flex-1 rounded-md p-2">
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="start_date" class="min-w-36">Start Date:</label>
            <input name="start_date" value="<?php echo $result['StartDate']; ?>" id="start_date" type="date" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="end_date" class="min-w-36">End Date:</label>
            <input name="end_date" value="<?php echo $result['EndDate']; ?>" id="end_date" type="date" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="description" class="min-w-36">Details:</label>
            <textarea id="description" name="description" rows="4" cols="50" class="p-2 rounded-md"><?php echo $result['OtherDescription']; ?></textarea>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>


    <script src="/assets/js/admission.js"></script>
    <script>
        $(window).click(function() {
            $('#search_results').remove();
        });

        $('#patient-div').click(function(event) {
            event.stopPropagation();
        });

        showDoctors();
        showNurses();
        showRooms();

        $('#patient').on('input', patientSearch).on('focus', patientSearch);

        function setPatient(id, Name) {
            $('#patient').val(id);
            $('#patient_name').val(Name);
            $('#search_results').remove();
        }

        function patientSearch() {
            var data = {
                scope: "secretary"
            };
            if ($('#patient').val()) {
                data.insurance_id = $('#patient').val();

            } else {
                $('#search_results').remove();
            }
            $.ajax({
                url: "/api/patients.php",
                data: data,
                success: function(response) {
                    data = JSON.parse(response);

                    if (data.results.length > 0) {
                        $('#search_results').remove();
                        $('#patient-div').append('<div id="search_results" class="absolute shadow-md left-0 right-0 bg-white z-[1000] max-h-44 overflow-y-auto"></div>');
                        $('#search_results').append('<div class="p-2 grid grid-cols-3"><p class="font-bold col-span-1">ID</p><p class="font-bold col-span-2">Name</p></div>');
                        data.results.forEach(function(item) {
                            name = item.LastName + ' ' + item.FirstName;
                            $('#search_results').append('<div onclick="setPatient(\'' + item.ID + '\', \'' + name + '\')" class="p-2 cursor-pointer grid grid-cols-3 hover:bg-gray-200"><p class="col-span-1">' + item.ID + '</p><p class="col-span-2">' + name + '</p></div>');
                        });
                    } else {
                        $('#search_results').remove();
                        $('#patient-div').append('<div id="search_results" class="p-2 absolute left-0 right-0 bg-white"><p>No results</p></div>');
                    }
                }
            });
        }

        function showRooms() {
            $.ajax({
                url: "/api/rooms.php",
                data: {},
                success: function(response) {
                    data = JSON.parse(response);

                    data.results.forEach(function(item) {
                        $("select[name='room_number']").append('<option value="' + item.RoomNumber + '">' + item.RoomNumber + '</option>');

                    });

                }
            });
        }

        function showNurses() {
            $.ajax({
                url: "/api/employees.php",
                data: {
                    type: "nurse"
                },
                success: function(response) {
                    data = JSON.parse(response);

                    data.results.forEach(function(item) {
                        $("select[name='nurse_id']").append('<option value="' + item.ID + '">' + item.lastName + ' ' + item.firstName + '</option>');

                    });

                }
            });
        }

        function showDoctors() {
            $.ajax({
                url: "/api/employees.php",
                data: {
                    type: "doctor"
                },
                success: function(response) {
                    data = JSON.parse(response);

                    data.results.forEach(function(item) {
                        $("select[name='doctor_id']").append('<option value="' + item.ID + '">' + item.lastName + ' ' + item.firstName + '</option>');

                    });

                }
            });
        }

        function deleteAction(id) {
            if (deleteAdmission(id)) {
                window.location.href = "/secretary/admissions/index.php";
            }
        }
    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>