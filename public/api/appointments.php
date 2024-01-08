<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET['scope'] == 'patient') {
        if (isset($_GET['doctor_id'], $_GET['appointment_date'])) {
            $stmt = $dbh->prepare('SELECT Appointment.Date FROM Appointment INNER JOIN Employee ON Appointment.DoctorID=Employee.ID WHERE CAST(Appointment.Date AS DATE)=:date AND Employee.ID=:doctor_id');
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
            $response['status'] = 'Please provide correct doctor_id and appointment_date!';
            echo json_encode($response);
            http_response_code(400);
            exit;
        }
    } elseif ($_GET['scope'] == 'doctor') {
        if (isset($_SESSION['type']) && $_SESSION['type'] == 'doctor') {
            if (isset($_GET['doctor_id'], $_GET['appointment_date'])) {
                if ($_GET['doctor_id'] != $_SESSION['employee_id']) {
                    $response['results'] = [];
                    $response['status'] = 'You can not view other doctors\' appointments!';
                    echo json_encode($response);
                    http_response_code(403);
                    exit;
                }
                $stmt = $dbh->prepare('SELECT p.ID, a.Date, p.LastName, p.FirstName FROM Appointment a INNER JOIN Employee e ON a.DoctorID=e.ID INNER JOIN Patient p ON p.ID=a.PatientID WHERE CAST(a.Date AS DATE)=:date AND e.ID=:doctor_id ORDER BY a.Date');
                $stmt->execute([':doctor_id' => $_GET['doctor_id'], ':date' => $_GET['appointment_date']]);

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $i => $result) {
                    $results[$i]['Date'] = date_format(date_create($result['Date']), "H:i");
                }
                $response['results'] = $results;
                $response['status'] = 'OK';
                echo json_encode($response);
            } else {
                $response['results'] = [];
                $response['status'] = 'Please provide correct doctor_id and appointment_date!';
                echo json_encode($response);
                http_response_code(400);
                exit;
            }
        } else {
            $response['results'] = [];
            $response['status'] = 'You do not have permission to access this resource!';
            echo json_encode($response);
            http_response_code(403);
        }
    } else {
        $response['results'] = [];
        $response['status'] = 'Please provide correct scope';
        echo json_encode($response);
        http_response_code(400);
        exit;
    }
    exit;
} else {
    $response['results'] = [];
    $response['status'] = 'Only GET Method allowed';
    echo json_encode($response);
    http_response_code(405);
    exit;
}
