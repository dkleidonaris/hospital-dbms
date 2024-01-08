<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Create new Employee";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $departmentID = (isset($_POST['department_id']) ? $_POST['department_id'] : null);
    if (isset($_POST['email'], $_POST['password'], $_POST['last_name'], $_POST['first_name'], $_POST['type'], $_POST['contact_number'])) {
        $stmt = $dbh->prepare('INSERT into Employee (email, password, lastName, firstName, type, departmentID, contactNumber) VALUES(?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['last_name'], $_POST['first_name'], $_POST['type'], $departmentID, $_POST['contact_number']]);

        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'The employee has been created!';
        header('Location: /secretary/employees/edit.php?id=' . $dbh->lastInsertId());
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
        <div class="my-4 flex items-center gap-2">
            <label for="email_address" class="min-w-36">Email Address:</label>
            <input name="email" id="email_address" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="password" class="min-w-36">Password:</label>
            <input name="password" id="password" type="password" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="password_confirm" class="min-w-36">Password Confirm:</label>
            <input id="password_confirm" type="password" class="flex-1 rounded-md p-2" required>
        </div>
        <div id="pwd_error" class="hidden my-2">
            <span class="text-red-500">The passwords do not match</span>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="first_name" class="min-w-36">First Name:</label>
            <input name="first_name" id="first_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="last_name" class="min-w-36">Last Name:</label>
            <input name="last_name" id="last_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div id="type-div" class="my-4 flex items-center gap-2">
            <label for="type" class="min-w-36">Employee Type:</label>
            <select name="type" id="type" class="flex-1 rounded-md p-2" required>
                <option value="">Select an option</option>
                <option value="doctor">Doctor</option>
                <option value="nurse">Nurse</option>
                <option value="secretary">Secretary</option>
            </select>
        </div>
        <div id="department-div" class="hidden my-4 flex items-center gap-2">
            <label for="department" class="min-w-36">Department:</label>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="contact_number" class="min-w-36">Contact Number:</label>
            <input name="contact_number" id="contact_number" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    <script src="/assets/js/employee.js"></script>
    <script>
    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>