<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if (empty($_SESSION['type']) || $_SESSION['type'] != 'doctor') {
    $response['results'] = [];
    $response['status'] = 'You do not have permission to access the selected resource';
    echo json_encode($response);
    http_response_code(403);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // $orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'InsuranceNumber';
    // $orderDirection = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'ASC';
    // $stmt = $dbh->prepare('SELECT a.ID as AdmissionID, p.ID as InsuranceNumber, p.FirstName as PatientFirstName, p.LastName as PatientLastName, d.ID as DoctorID, d.LastName as DoctorLastName, d.FirstName as DoctorFirstName, n.LastName as NurseLastName, n.FirstName as NurseFirstName, a.StartDate, a.EndDate, a.RoomNumber, a.Reason FROM Patient p INNER JOIN Admission a ON p.ID=a.PatientID INNER JOIN Employee n on a.NurseID=n.ID INNER JOIN Employee d ON a.DoctorID=d.ID WHERE p.ID=:id ORDER BY ' . $orderBy . ' ' . $orderDirection);
    // $stmt->execute([':id' => $_GET['insurance_id']]);
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $response['results'] = $results;
    // echo json_encode($response);
    // exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (empty($_SESSION['type']) || $_SESSION['type'] != 'doctor') {
        $response['results'] = [];
        $response['status'] = 'You do not have permission to access the selected resource';
        echo json_encode($response);
        http_response_code(403);
        exit;
    }
    parse_str(file_get_contents('php://input'), $DELETE);

    if (isset($DELETE['id'])) {
        $stmt = $dbh->prepare('SELECT * FROM Medication WHERE ID=:id');
        $stmt->execute([':id' => $DELETE['id']]);
        if ($stmt->rowCount() > 0) {
            $dbh->prepare('DELETE FROM Medication WHERE id=?')->execute([$DELETE['id']]);

            $response['status'] = 'The medication has been deleted';
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'The medication that you are trying to delete does not exist!';
            echo json_encode($response);

            http_response_code(404);
            exit;
        }
    } else {
        $response['status'] = 'Please provide medication id for deletion!';
        echo json_encode($response);

        http_response_code(400);
        exit;
    }
} else {
    http_response_code(405);
    exit;
}
