<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Edit Admission";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $dbh->prepare('INSERT INTO Admission (PatientID, DoctorID, NurseID, StartDate, EndDate, RoomNumber, Reason) VALUES(?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['insurance_id'], $_POST['doctor_id'], $_POST['nurse_id'], $_POST['start_date'], $_POST['end_date'], $_POST['room_number'], $_POST['reason']]);

    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'The admission has been created!';
    header('Location: /secretary/admissions/edit.php?id=' . $dbh->lastInsertId());
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


    <div class="flex justify-center py-4">
        <button onclick="deleteAction('<?php echo $result['AdmissionID']; ?>')" type="button" class="mx-auto inline-flex gap-2 items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Delete
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 fill-white cursor-pointer">
                <g>
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path d="M7 4V2h10v2h5v2h-2v15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6H2V4h5zM6 6v14h12V6H6zm3 3h2v8H9V9zm4 0h2v8h-2V9z" />
                </g>
            </svg>
        </button>
    </div>


    <form class="max-w-md mx-auto" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="my-4 flex items-center gap-2">
            <label for="patient" class="min-w-36">Patient:</label>
            <div id="patient-div" class="flex-1 relative">
                <input name="insurance_id" id="patient" placeholder="Search for patient by insurance Number" type="text" class="w-full rounded-md p-2 flex-1">
            </div>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="patient_name" class="min-w-36">Patient Name:</label>
            <input id="patient_name" type="text" class="w-full  text-gray-700 bg-gray-400 rounded-md p-2 flex-1" readonly>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="doctor" class="min-w-36">Doctor in charge:</label>
            <select name="doctor_id" id="doctor" class="flex-1 rounded-md p-2">
                <option value="">Select a doctor</option>
            </select>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="nurse" class="min-w-36">Nurse in charge:</label>
            <select name="nurse_id" id="doctor" class="flex-1 rounded-md p-2">
                <option value="">Select a nurse</option>
            </select>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="start_date" class="min-w-36">Admission Date:</label>
            <input name="start_date" id="start_date" type="date" class="flex-1 rounded-md p-2">
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="end_date" class="min-w-36">Discharge Date:</label>
            <input name="end_date" id="end_date" type="date" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="room" class="min-w-36">Room:</label>
            <select name="room_number" id="room" class="flex-1 p-2 rounded-md">
                <option value="">Select a room</option>
            </select>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="reason" class="min-w-36">Reason:</label>
            <textarea id="reason" name="reason" rows="4" cols="50" class="p-2 rounded-md"></textarea>
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
                    console.log(data);

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