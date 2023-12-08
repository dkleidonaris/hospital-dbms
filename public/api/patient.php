<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (count($_GET) != 2) {
        $response['results'] = [];
        $response['status'] = 'Please provide insurance_id & correct scope';
        echo json_encode($response);

        http_response_code(405);
        exit;
    }
    if (isset($_GET['insurance_id'], $_GET['scope']) && $_GET['scope'] == 'appointment') {
        $stmt = $dbh->prepare('SELECT ID, LastName, FirstName FROM Patient WHERE ID=:id');
        $stmt->execute([':id' => $_GET['insurance_id']]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['results'] = $results;
        $response['status'] = 'OK';

        echo json_encode($response);
        exit;
    } elseif ((isset($_GET['insurance_id'], $_GET['scope']) && $_GET['scope'] == 'doctor')) {
        $stmt = $dbh->prepare('SELECT * FROM Patient p WHERE p.ID=:id');
        $stmt->execute(array(':id'=> $_GET['insurance_id']));
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $response['results']['patient'] = $results;

        $stmt = $dbh->prepare('SELECT n.LastName as NurseLastName, n.FirstName as NurseFirstName, a.StartDate, a.EndDate, a.RoomNumber FROM Patient p INNER JOIN Admission a ON p.ID=a.PatientID INNER JOIN Nurse n on a.NurseID=n.ID WHERE p.ID=:id');
        $stmt->execute(array(':id'=> $_GET['insurance_id']));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response['results']['admissions'] = $results;

        $stmt = $dbh->prepare('SELECT d.LastName as DoctorLastName, m.Name, m.Dosage, m.Frequency, m.StartDate, m.EndDate, m.OtherDescription FROM Medication m INNER JOIN Patient p ON m.PatientID=p.ID INNER JOIN Doctor d ON m.DoctorID=d.ID WHERE p.ID=:id');
        $stmt->execute(array(':id'=> $_GET['insurance_id']));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response['results']['medication'] = $results;

        $stmt = $dbh->prepare('SELECT n.LastName as NurseLastName, a.StartDate, a.EndDate, a.RoomNumber, a.Reason FROM Admission a INNER JOIN Patient p ON a.PatientID=p.ID INNER JOIN Nurse n ON a.NurseID=n.ID WHERE p.ID=:id ORDER BY a.EndDate DESC');
        $stmt->execute(array(':id'=> $_GET['insurance_id']));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response['results']['admissions'] = $results;

        $response['status'] = 'OK';

        echo json_encode($response);
        exit;
    } else {
        $response['results'] = [];
        $response['status'] = 'Please provide only insurance_id & correct scope';
        echo json_encode($response);

        http_response_code(405);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insurance_number'], $_POST['first_name'], $_POST['last_name'], $_POST['date_of_birth'], $_POST['gender'], $_POST['contact_number'], $_POST['email_address'], $_POST['address'])) {
        $stmt = $dbh->prepare('INSERT into Patient (ID, FirstName, LastName, DateOfBirth, Gender, ContactNumber, EmailAddress, Address) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['insurance_number'], $_POST['first_name'], $_POST['last_name'], $_POST['date_of_birth'], $_POST['gender'], $_POST['contact_number'], $_POST['email_address'], $_POST['address']]);

        $response['results'] = [['ID' => $_POST['insurance_number'], 'LastName' => $_POST['last_name'], 'FirstName' => $_POST['first_name']]];
        $response['status'] = 'OK';

        echo json_encode($response);
        exit;
    } else {
        http_response_code(405);
        exit;
    }
} else {
    http_response_code(405);
    exit;
}
