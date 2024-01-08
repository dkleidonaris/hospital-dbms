<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Create new Department";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $departmentID = (isset($_POST['department_id']) ? $_POST['department_id'] : null);
    if (isset($_POST['name'])) {
        $stmt = $dbh->prepare('INSERT into Department (Name) VALUES(?)');
        $stmt->execute([$_POST['name']]);

        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'The department has been created!';
        header('Location: /secretary/departments/edit.php?id=' . $dbh->lastInsertId());
        exit;
    } else {
        header('Location: /secretary/departments/create.php');
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
            <label for="name" class="min-w-36">Name:</label>
            <input name="name" id="name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    <script src="/assets/js/employee.js"></script>
    <script>
    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>