<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Create new Patient";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insurance_number'], $_POST['first_name'], $_POST['last_name'], $_POST['date_of_birth'], $_POST['gender'], $_POST['contact_number'], $_POST['email_address'], $_POST['address'])) {
        $stmt = $dbh->prepare('INSERT into Patient (ID, FirstName, LastName, DateOfBirth, Gender, ContactNumber, EmailAddress, Address) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['insurance_number'], $_POST['first_name'], $_POST['last_name'], $_POST['date_of_birth'], $_POST['gender'], $_POST['contact_number'], $_POST['email_address'], $_POST['address']]);

        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'The patient has been created!';
        header('Location: /secretary/patients/edit.php?id=' . $_POST['insurance_number']);
        exit;
    } else {
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
        <div id="insurance_div" class="my-4 flex items-center gap-2">
            <label for="insurance_number" class="min-w-36">Insurance Number:</label>
            <input name="insurance_number" id="insurance_number" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="last_name" class="min-w-36">Last Name:</label>
            <input name="last_name" id="last_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="first_name" class="min-w-36">First Name:</label>
            <input name="first_name" id="first_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="gender" class="min-w-36">Gender:</label>
            <select name="gender" id="gender" class="flex-1 rounded-md p-2" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="date_of_birth" class="min-w-36">Date of Birth:</label>
            <input name="date_of_birth" id="date_of_birth" type="date" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="email_address" class="min-w-36">Email Address:</label>
            <input name="email_address" id="email_address" type="email" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="contact_number" class="min-w-36">Contact Number:</label>
            <input name="contact_number" id="contact_number" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="address" class="min-w-36">Address:</label>
            <input name="address" id="address" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>


    <script>
        $('#insurance_number').on('input', function() {
            $.ajax({
                url: '/api/patients.php',
                data: {
                    scope: 'secretary',
                    insurance_id: $('#insurance_number').val(),
                    match: 'exact'
                },
                success: function(response) {
                    data = JSON.parse(response);

                    $('#department').append('<option value="">Select a department</option>');

                    $('#id_error').remove();
                    if (data.results.length > 0) {
                        $('#insurance_div').after('<p id="id_error" class="text-red-500">This patient already exists!</p>');
                        $("form").submit(function(e) {
                            e.preventDefault();
                        });
                    } else {
                        $("form").unbind('submit');
                    }
                }
            });
        });
    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>