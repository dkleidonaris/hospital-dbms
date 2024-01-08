<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Edit Employee";

if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
    if (isset($_GET['id'])) {
        $stmt = $dbh->prepare('SELECT * FROM Department WHERE ID=:id');
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
    $stmt = $dbh->prepare('UPDATE Department SET name=? WHERE ID=?');
    $stmt->execute([$_POST['name'], $_POST['id']]);

    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'Your changes have been saved!';
    header('Location: /secretary/departments/edit.php?id=' . $_POST['id']);
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
            <label for="name" class="min-w-36">Name:</label>
            <input name="name" value="<?php echo $result['Name']; ?>" id="name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    <script src="/assets/js/department.js"></script>
    <script>
        var DepartmentID = <?php echo $result['ID']; ?>;

        function deleteAction(id) {
            deleteDepartment(id);
            window.location.href = "/secretary/departments/index.php";
        }
    </script>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>