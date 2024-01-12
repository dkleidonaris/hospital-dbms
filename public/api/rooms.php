<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

// if (empty($_SESSION['type']) || $_SESSION['type'] != 'secretary') {
//     $response['results'] = [];
//     $response['status'] = 'You do not have permission to access the selected resource';
//     echo json_encode($response);
//     http_response_code(403);
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $params = [];
    $orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'RoomNumber';
    $orderDirection = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'ASC';

    if (isset($_GET['change_room_number'])) {
        $stmt = $dbh->prepare("SELECT Room.RoomNumber, Department.Name as DepartmentName FROM Room JOIN Department ON Room.departmentID=Department.ID WHERE Room.RoomNumber=? UNION SELECT Room.RoomNumber, Department.Name as DepartmentName FROM Room JOIN Department ON Room.DepartmentID=Department.ID WHERE Room.RoomNumber NOT IN (SELECT R.RoomNumber FROM Room R JOIN Admission A ON R.RoomNumber=A.RoomNumber) ORDER BY " . $orderBy . " " . $orderDirection);
        $stmt->execute(array($_GET['change_room_number']));

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $response['results'] = $results;
        $response['status'] = 'OK';

        echo json_encode($response);
        exit;
    }

    if (isset($_GET['q'])) {
        $params[':room_number'] = $_GET['q'];
    }
    if (isset($_GET['department_id'])) {
        $params[':department_id'] = $_GET['department_id'];
        $stmt = $dbh->prepare("SELECT R.RoomNumber, D.Name as DepartmentName FROM Room R JOIN Department D ON R.departmentID=D.ID WHERE" .  (isset($_GET['q']) ? " R.RoomNumber=:room_number AND" : "") . " R.DepartmentID=:department_id AND R.RoomNumber NOT IN (SELECT Room.RoomNumber FROM Room JOIN Admission ON Room.RoomNumber=Admission.RoomNumber) ORDER BY " . $orderBy . " " . $orderDirection);
    } else {
        $stmt = $dbh->prepare("SELECT R.RoomNumber, D.Name as DepartmentName FROM Room R JOIN Department D ON R.departmentID=D.ID WHERE " .  (isset($_GET['q']) ? " R.RoomNumber=:room_number AND" : "") . " R.RoomNumber NOT IN (SELECT Room.RoomNumber FROM Room JOIN Admission ON Room.RoomNumber=Admission.RoomNumber) ORDER BY " . $orderBy . " " . $orderDirection);
    }
    $stmt->execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $response['results'] = $results;
    $response['status'] = 'OK';

    echo json_encode($response);
    exit;
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
        $stmt = $dbh->prepare('SELECT * FROM Room WHERE RoomNumber=:id');
        $stmt->execute([':id' => $DELETE['id']]);
        if ($stmt->rowCount() > 0) {
            $dbh->prepare('DELETE FROM Room WHERE RoomNumber=?')->execute([$DELETE['id']]);

            $response['status'] = 'The room has been deleted';
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'The room that you are trying to delete does not exist!';
            echo json_encode($response);

            http_response_code(404);
            exit;
        }
    } else {
        $response['status'] = 'Please provide id for deletion!';
        echo json_encode($response);

        http_response_code(400);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
} else {
    http_response_code(405);
    exit;
}
