<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (count($_GET) != 3) {
        $response['results'] = [];
        $response['status'] = 'Please provide only doctor_id and appointment_date as parameters';

        echo json_encode($response);
        http_response_code(400);
        exit;
    }

    if ($_GET['scope'] == 'patient') {
        $stmt = $dbh->prepare('SELECT Appointment.Date FROM Appointment INNER JOIN Doctor ON Appointment.DoctorID=Doctor.ID WHERE CAST(Appointment.Date AS DATE)=:date AND Doctor.ID=:doctor_id');
        $stmt->execute([':doctor_id' => $_GET['doctor_id'], ':date' => $_GET['appointment_date']]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $i => $result) {
            $results[$i]['Date'] = date_format(date_create($result['Date']), "H:i");
        }
        $response['results'] = $results;
        $response['status'] = 'OK';
    } elseif ($_GET['scope'] == 'doctor') {
        $stmt = $dbh->prepare('SELECT a.Date, p.LastName, p.FirstName FROM Appointment a INNER JOIN Doctor d ON a.DoctorID=d.ID INNER JOIN Patient p ON p.ID=a.PatientID WHERE CAST(a.Date AS DATE)=:date AND d.ID=:doctor_id ORDER BY a.Date');
        $stmt->execute([':doctor_id' => $_SESSION['doctor_id'], ':date' => $_GET['appointment_date']]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $i => $result) {
            $results[$i]['Date'] = date_format(date_create($result['Date']), "H:i");
        }
        $response['results'] = $results;
        $response['status'] = 'OK';
    } else {
        $response['results'] = [];
        $response['status'] = 'Please provide scope';
    }

    echo json_encode($response);
    exit;
} else {
    $response['results'] = [];
    $response['status'] = 'Only GET Method allowed';
    echo json_encode($response);
    http_response_code(405);
    exit;
}
