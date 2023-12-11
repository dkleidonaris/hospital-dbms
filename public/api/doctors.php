<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (count($_GET) > 1) {
        $response['results'] = [];
        $response['status'] = 'More than one parameters provided';

        echo json_encode($response);
        http_response_code(400);
        die;
    }

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
        $response['status'] = 'No parameters provided';

        echo json_encode($response);
        die;
    }
} else {
    http_response_code(405);
    exit;
}
