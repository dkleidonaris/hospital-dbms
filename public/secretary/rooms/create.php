<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Create new Room";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['room_number'], $_POST['department_id'])) {

        $stmt = $dbh->prepare('INSERT INTO Room (RoomNumber, DepartmentID) VALUES(?, ?)');
        $stmt->execute([$_POST['room_number'], $_POST['department_id']]);

        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'The room has been created!';
        header('Location: /secretary/rooms/edit.php?id=' . $_POST['room_number']);
        exit;
    } else {
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Please provide all needed paramters!';
        header('Location: /secretary/patients/create.php');
        exit;
    }
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
        <div id="room_div" class="my-4 flex items-center gap-2">
            <label for="room_number" class="min-w-36">Room Number:</label>
            <input name="room_number" id="room_number" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="department" class="min-w-36">Department:</label>
            <select name="department_id" id="department" class="rounded-md p-2" required></select>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>


    <script>
        $('#room_number').on('input', function() {
            $.ajax({
                url: "/api/rooms.php",
                data: {
                    q: $('#room_number').val()
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    if (data.results.length > 0) {
                        $('#room_div').after('<p id="room_error" class="text-red-500">This room already exists!</p>');
                        $("form").submit(function(e) {
                            e.preventDefault();
                        });
                    } else {
                        $("form").unbind('submit');
                        $('#room_error').remove();
                    }

                }
            });
        });
        showDepartments();

        function showDepartments() {
            $.ajax({
                url: "/api/departments.php",
                data: {},
                success: function(result) {
                    var data = JSON.parse(result);

                    $('#department').append('<option value="">Select a department</option>');

                    data.results.forEach(function(item) {
                        $('#department').append('<option value="' + item.ID + '">' + item.Name + '</option>');
                    });
                }
            });
        }
    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>