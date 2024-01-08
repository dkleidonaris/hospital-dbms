<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['scope']) && $_GET['scope'] == 'shift') {
        // if (isset($_SESSION['type']) || $_SESSION['type'] != 'nurse') {
        //     $response['results'] = [];
        //     $response['status'] = 'You do not have permission to access this resource!';
        //     echo json_encode($response);

        //     http_response_code(403);
        //     exit;
        // }
        $currDate = date('Y-m-d');

        $stmt = $dbh->prepare('SELECT p.ID as InsuranceID, p.FirstName as PatientFirstName, p.LastName as PatientLastName, p.DateOfBirth, p.Gender, e.LastName as DoctorLastName, a.StartDate, a.EndDate, a.RoomNumber, a.Reason FROM Admission a INNER JOIN Patient p ON a.PatientID=p.ID INNER JOIN Employee e ON a.DoctorID=e.ID WHERE a.NurseID=:id AND (a.EndDate>=:date OR a.EndDate IS NULL)');
        $stmt->execute([':id' => $_SESSION['employee_id'], ':date' => $currDate]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['results'] = $results;
        $response['status'] = 'OK';

        echo json_encode($response);
        exit;
    } else {
        $response['status'] = 'This is not allowed!';
        echo json_encode($response);

        http_response_code(400);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['type']) && $_SESSION['type'] == 'secretary') {
        if (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['contactNumber'])) {
            $stmt = $dbh->prepare('INSERT INTO Employee (email, password, firstName, lastName, type, contactNumber) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(array($_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['firstName'], $_POST['lastName'], 'nurse', $_POST['contactNumber']));
            $response['status'] = 'Nurse ' . $_POST['lastName'] . ' ' . $_POST['firstName'] . ' has been created';

            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'Please provide all parameters needed for creating a doctor!';
            echo json_encode($response);

            http_response_code(400);
            exit;
        }
    } else {
        $response['status'] = 'You do not have permission to create this resource!';
        echo json_encode($response);
        http_response_code(403);
        exit;
    }
} else {
    http_response_code(405);
    exit;
}
