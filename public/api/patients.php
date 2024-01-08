<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['scope'])) {
        if ($_GET['scope'] == 'appointment') {
            if (isset($_GET['insurance_id'])) {
                $stmt = $dbh->prepare('SELECT ID, LastName, FirstName FROM Patient WHERE ID=:id');
                $stmt->execute([':id' => $_GET['insurance_id']]);

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response['results'] = $results;
                $response['status'] = 'OK';

                echo json_encode($response);
                exit;
            } else {
                $response['results'] = [];
                $response['status'] = 'Please provide insurance_id!';
                echo json_encode($response);

                http_response_code(400);
                exit;
            }
        } elseif ($_GET['scope'] == 'doctor') {
            if (empty($_SESSION['type']) || $_SESSION['type'] != 'doctor') {
                $response['results'] = [];
                $response['status'] = 'You do not have permission to access the selected resource';
                echo json_encode($response);
                http_response_code(403);
                exit;
            }

            if (isset($_GET['insurance_id'])) {
                $stmt = $dbh->prepare('SELECT * FROM Patient p WHERE p.ID=:id');
                $stmt->execute(array(':id' => $_GET['insurance_id']));
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['results']['patient'] = $results;

                $stmt = $dbh->prepare('SELECT d.LastName as DoctorLastName, d.FirstName as DoctorFirstName, n.LastName as NurseLastName, n.FirstName as NurseFirstName, a.StartDate, a.EndDate, a.RoomNumber, a.Reason FROM Patient p INNER JOIN Admission a ON p.ID=a.PatientID INNER JOIN Employee n on a.NurseID=n.ID INNER JOIN Employee d ON a.DoctorID=d.ID WHERE p.ID=:id');
                $stmt->execute(array(':id' => $_GET['insurance_id']));
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response['results']['admissions'] = $results;

                $stmt = $dbh->prepare('SELECT d.LastName as DoctorLastName, m.Name, m.Dosage, m.Frequency, m.StartDate, m.EndDate, m.OtherDescription FROM Medication m INNER JOIN Patient p ON m.PatientID=p.ID INNER JOIN Employee d ON m.DoctorID=d.ID WHERE p.ID=:id');
                $stmt->execute(array(':id' => $_GET['insurance_id']));
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response['results']['medication'] = $results;

                $response['status'] = 'OK';
                echo json_encode($response);
            } else {
                $response['results'] = [];
                $response['status'] = 'Please provide insurance_id!';
                echo json_encode($response);

                http_response_code(400);
                exit;
            }
        } elseif ($_GET['scope'] == 'nurse') {
            if (empty($_SESSION['type']) || $_SESSION['type'] != 'nurse') {
                $response['results'] = [];
                $response['status'] = 'You do not have permission to access the selected resource';
                echo json_encode($response);
                http_response_code(403);
                exit;
            }

            if (isset($_GET['insurance_id'])) {
                $stmt = $dbh->prepare('SELECT * FROM Patient p WHERE p.ID=:id');
                $stmt->execute(array(':id' => $_GET['insurance_id']));
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['results']['patient'] = $results;

                $stmt = $dbh->prepare('SELECT d.LastName as DoctorLastName, d.FirstName as DoctorFirstName, n.LastName as NurseLastName, n.FirstName as NurseFirstName, a.StartDate, a.EndDate, a.RoomNumber, a.Reason FROM Patient p INNER JOIN Admission a ON p.ID=a.PatientID INNER JOIN Employee n on a.NurseID=n.ID INNER JOIN Employee d ON a.DoctorID=d.ID WHERE p.ID=:id');
                $stmt->execute(array(':id' => $_GET['insurance_id']));
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response['results']['admissions'] = $results;

                $stmt = $dbh->prepare('SELECT d.LastName as DoctorLastName, m.Name, m.Dosage, m.Frequency, m.StartDate, m.EndDate, m.OtherDescription FROM Medication m INNER JOIN Patient p ON m.PatientID=p.ID INNER JOIN Employee d ON m.DoctorID=d.ID WHERE p.ID=:id');
                $stmt->execute(array(':id' => $_GET['insurance_id']));
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response['results']['medication'] = $results;

                $response['status'] = 'OK';
                echo json_encode($response);
            } else {
                $response['results'] = [];
                $response['status'] = 'Please provide insurance_id!';
                echo json_encode($response);

                http_response_code(400);
                exit;
            }
        } elseif ($_GET['scope'] == 'secretary') {
            // if (empty($_SESSION['type']) || $_SESSION['type'] != 'secretary') {
            //     $response['results'] = [];
            //     $response['status'] = 'You do not have permission to access the selected resource';
            //     echo json_encode($response);
            //     http_response_code(403);
            //     exit;
            // }
            $orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'ID';
            $orderDirection = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'ASC';

            if (isset($_GET['insurance_id'])) {
                if (isset($_GET['match']) && $_GET['match'] == 'exact') {
                    $stmt = $dbh->prepare("SELECT * FROM Patient WHERE ID=? ORDER BY " . $orderBy . " " . $orderDirection);
                } else {
                    $stmt = $dbh->prepare("SELECT * FROM Patient WHERE ID LIKE CONCAT(?,'%') ORDER BY " . $orderBy . " " . $orderDirection);

                }
                $stmt->execute(array($_GET['insurance_id']));
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $dbh->prepare('SELECT * FROM Patient ORDER BY ' . $orderBy . " " . $orderDirection);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $response['results'] = $results;
            $response['status'] = 'OK';

            echo json_encode($response);
            exit;
        } else {
            $response['results'] = [];
            $response['status'] = 'Incorrect scope!';
            echo json_encode($response);

            http_response_code(400);
            exit;
        }
    } else {
        $response['results'] = [];
        $response['status'] = 'Please provide scope';
        echo json_encode($response);

        http_response_code(400);
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
        http_response_code(400);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // if (empty($_SESSION['type']) || $_SESSION['type'] != 'secretary') {
    //     $response['results'] = [];
    //     $response['status'] = 'You do not have permission to access the selected resource';
    //     echo json_encode($response);
    //     http_response_code(403);
    //     exit;
    // }
    parse_str(file_get_contents('php://input'), $DELETE);

    if (isset($DELETE['id'])) {
        $stmt = $dbh->prepare('SELECT * FROM Patient WHERE ID=:id');
        $stmt->execute([':id' => $DELETE['id']]);
        if ($stmt->rowCount() > 0) {
            $dbh->prepare('DELETE FROM Patient WHERE id=?')->execute([$DELETE['id']]);

            $response['status'] = 'The patient has been deleted';
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'The patient that you are trying to delete does not exist!';
            echo json_encode($response);

            http_response_code(404);
            exit;
        }
    } else {
        $response['status'] = 'Please provide insurance id for deletion!';
        echo json_encode($response);

        http_response_code(400);
        exit;
    }
} else {
    http_response_code(405);
    exit;
}
