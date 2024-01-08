<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Edit Employee";

if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
    if (isset($_GET['id'])) {
        $stmt = $dbh->prepare('SELECT * FROM Employee WHERE ID=:id');
        $stmt->execute([':id' => $_GET['id']]);
        if (!$stmt->rowCount()) {
            http_response_code(404);
            exit;
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        http_response_code(404);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $departmentID = (isset($_POST['department_id']) ? $_POST['department_id'] : null);
    if (!empty($_POST['password'])) {
        $stmt = $dbh->prepare('UPDATE Employee SET email=?, password=?, lastName=?, firstName=?, type=?, departmentID=?, contactNumber=? WHERE ID=?');
        $stmt->execute([$_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['last_name'], $_POST['first_name'], $_POST['type'], $departmentID, $_POST['contact_number'], $_POST['id']]);
    } else {
        $stmt = $dbh->prepare('UPDATE Employee SET email=?, lastName=?, firstName=?, type=?, departmentID=?, contactNumber=? WHERE ID=?');
        $stmt->execute([$_POST['email'], $_POST['last_name'], $_POST['first_name'], $_POST['type'], $departmentID, $_POST['contact_number'], $_POST['id']]);
    }
    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'Your changes have been saved!';
    header('Location: /secretary/employees/edit.php?id=' . $_POST['id']);
    exit;
} else {
    http_response_code(400);
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
        <button onclick="deleteAction('<?php echo $_GET['id']; ?>')" type="button" class="mx-auto inline-flex gap-2 items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
            <label for="id" class="min-w-36">ID:</label>
            <input name="id" value="<?php echo $result['ID']; ?>" id="id" type="text" class="bg-gray-200 text-gray-700 flex-1 rounded-md p-2" readonly>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="email_address" class="min-w-36">Email Address:</label>
            <input name="email" value="<?php echo $result['email']; ?>" id="email_address" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="password" class="min-w-36">Password:</label>
            <input name="password" id="password" type="password" class="flex-1 rounded-md p-2">
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="password_confirm" class="min-w-36">Password Confirm:</label>
            <input id="password_confirm" type="password" class="flex-1 rounded-md p-2">
        </div>
        <div id="pwd_error" class="hidden my-2">
            <span class="text-red-500">The passwords do not match</span>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="first_name" class="min-w-36">First Name:</label>
            <input name="first_name" value="<?php echo $result['firstName']; ?>" id="first_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="last_name" class="min-w-36">Last Name:</label>
            <input name="last_name" value="<?php echo $result['lastName']; ?>" id="last_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div id="type-div" class="my-4 flex items-center gap-2">
            <label for="type" class="min-w-36">Employee Type:</label>
            <select name="type" id="type" class="flex-1 rounded-md p-2" required>
                <option value="">Select an option</option>
                <option value="doctor" <?php echo ($result['type'] == 'doctor') ? 'selected' : '' ?>>Doctor</option>
                <option value="nurse" <?php echo ($result['type'] == 'nurse') ? 'selected' : '' ?>>Nurse</option>
                <option value="secretary" <?php echo ($result['type'] == 'secretary') ? 'selected' : '' ?>>Secretary</option>
            </select>
        </div>
        <div id="department-div" class="<?php echo ($result['type'] == 'doctor') ? '' : 'hidden' ?> my-4 flex items-center gap-2">
            <label for="department" class="min-w-36">Department:</label>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="contact_number" class="min-w-36">Contact Number:</label>
            <input name="contact_number" value="<?php echo $result['contactNumber']; ?>" id="contact_number" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    <script src="/assets/js/employee.js"></script>
    <script>
        var DepartmentID = <?php echo $result['departmentID']; ?>;

        function deleteAction(id) {
            deleteEmployee(id);
            window.location.href = "/secretary/employees/index.php";
        }
    </script>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>