<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (count($_GET) != 2) {
        $response['results'] = [];
        $response['status'] = 'Please provide only doctor_id and appointment_date as parameters';

        echo json_encode($response);
        http_response_code(400);
        exit;
    }

    $stmt = $dbh->prepare('SELECT Appointment.Date FROM Appointment INNER JOIN Doctor ON Appointment.DoctorID=Doctor.ID WHERE CAST(Appointment.Date AS DATE)=:date AND Doctor.ID=:doctor_id');
    $stmt->execute([':doctor_id' => $_GET['doctor_id'], ':date' => $_GET['appointment_date']]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $i => $result) {
        $results[$i]['Date'] = date_format(date_create($result['Date']), "H:i");
    }
    $response['results'] = $results;
    $response['status'] = 'OK';

    echo json_encode($response);
    exit;
} else {
    $response['results'] = [];
    $response['status'] = 'Only GET Method allowed';
    echo json_encode($response);
    http_response_code(405);
    exit;
}
