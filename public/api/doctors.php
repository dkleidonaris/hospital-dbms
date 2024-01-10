<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['department_id'])) {
        $stmt = $dbh->prepare('SELECT Employee.id, Employee.LastName, Employee.FirstName FROM Employee INNER JOIN Department ON Employee.DepartmentID=Department.ID WHERE Employee.DepartmentID=:id AND Employee.type=\'doctor\'');
        $stmt->execute([':id' => $_GET['department_id']]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response['results'] = $results;

        $response['status'] = 'OK';

        echo json_encode($response);
        exit;
    } else {
        $response['results'] = [];

        $response['status'] = 'Not allowed!';

        echo json_encode($response);
        http_response_code(400);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['type']) && $_SESSION['type'] == 'secretary') {
        if (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['departmentID'], $_POST['contactNumber'])) {
            $stmt = $dbh->prepare('INSERT INTO Employee (email, password, firstName, lastName, type, departmentID, contactNumber) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(array($_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['firstName'], $_POST['lastName'], 'doctor', $_POST['departmentID'], $_POST['contactNumber']));
            $response['status'] = 'Doctor ' . $_POST['lastName'] . ' ' . $_POST['firstName'] . ' has been created';

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
