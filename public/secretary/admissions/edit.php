<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Edit Admission";

if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
    if (isset($_GET['id'])) {
        $stmt = $dbh->prepare('SELECT P.LastName as PatientLastName, P.FirstName as PatientFirstName, D.ID as DoctorID, N.ID as NurseID, A.StartDate, A.EndDate, A.RoomNumber, A.Reason FROM Admission A JOIN Patient P ON A.PatientID=P.ID JOIN Employee D ON A.DoctorID=D.ID JOIN Employee N ON A.NurseID=N.ID WHERE A.ID=:id');
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
    $stmt = $dbh->prepare('UPDATE Admission SET DoctorID=?, NurseID=?, StartDate=?, EndDate=?, RoomNumber, Reason=? WHERE ID=?');
    $stmt->execute([$_POST['doctor_id'], $_POST['nurse_id'], $_POST['start_date'], $_POST['end_date'], $_POST['room_number'], $_POST['reason'], $_POST['id']]);

    $_SESSION['message_type'] = 'info';
    $_SESSION['message'] = 'Your changes have been saved!';
    header('Location: /secretary/admissions/edit.php?id=' . $_POST['id']);
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
            <label for="id" class="min-w-36">Insurance Number:</label>
            <input name="id" value="<?php echo $result['ID']; ?>" id="id" type="text" class="bg-gray-200 text-gray-700 flex-1 rounded-md p-2" readonly>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="patient_name" class="min-w-36">Last Name:</label>
            <input name="patient_name" value="<?php echo $result['LastName']; ?>" id="patient_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="first_name" class="min-w-36">First Name:</label>
            <input name="first_name" value="<?php echo $result['FirstName']; ?>" id="first_name" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="gender" class="min-w-36">Gender:</label>
            <select name="gender" id="gender" class="flex-1 rounded-md p-2" required>
                <option value="male" <?php echo ($result['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($result['Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="date_of_birth" class="min-w-36">Date of Birth:</label>
            <input name="date_of_birth" value="<?php echo $result['DateOfBirth']; ?>" id="date_of_birth" type="date" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="email_address" class="min-w-36">Email Address:</label>
            <input name="email_address" value="<?php echo $result['EmailAddress']; ?>" id="email_address" type="email" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="contact_number" class="min-w-36">Contact Number:</label>
            <input name="contact_number" value="<?php echo $result['ContactNumber']; ?>" id="contact_number" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <div class="my-4 flex items-center gap-2">
            <label for="address" class="min-w-36">Address:</label>
            <input name="address" value="<?php echo $result['Address']; ?>" id="address" type="text" class="flex-1 rounded-md p-2" required>
        </div>
        <button id="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>


    <script src="/assets/js/patient.js"></script>
    <script>
        function deleteAction(id) {
            if (deleteAdmission(id)) {
                window.location.href = "/secretary/admissions/index.php";
            }
        }
    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>