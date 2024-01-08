<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // if (empty($_SESSION['type']) || $_SESSION['type'] != 'secretary') {
    //     $response['results'] = [];
    //     $response['status'] = 'You do not have permission to access the selected resource';
    //     echo json_encode($response);
    //     http_response_code(403);
    //     exit;
    // }

    $orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'ID';
    $orderDirection = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'ASC';

    // if (isset($_GET['q'])) {
    //     if (isset($_GET['type'])) {
    //         $stmt = $dbh->prepare("SELECT E.ID, E.email, E.firstName, E.lastName, E.type, D.ID as DepartmentID, D.Name as DepartmentName, E.contactNumber FROM Employee E LEFT JOIN Department D ON E.departmentID=D.ID WHERE " . isset($_GET['type']) ? "E.lastName LIKE CONCAT('%', ?,'%') AND" : "" . " E.type = ? ORDER BY E." . $orderBy . " " . $orderDirection);
    //         $stmt->execute(array($_GET['q'], $_GET['type']));
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } else {
    //         $stmt = $dbh->prepare("SELECT E.ID, E.email, E.firstName, E.lastName, E.type, D.ID as DepartmentID, D.Name as DepartmentName, E.contactNumber FROM Employee E LEFT JOIN Department D ON E.departmentID=D.ID WHERE E.lastName LIKE CONCAT('%', ?,'%') ORDER BY E." . $orderBy . " " . $orderDirection);
    //         $stmt->execute(array($_GET['q']));
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     }
    // } else {
    //     if (isset($_GET['type'])) {
    //         $stmt = $dbh->prepare("SELECT E.ID, E.email, E.firstName, E.lastName, E.type, D.ID as DepartmentID, D.Name as DepartmentName, E.contactNumber FROM Employee E LEFT JOIN Department D ON E.departmentID=D.ID WHERE E.type = ? ORDER BY E." . $orderBy . " " . $orderDirection);
    //         $stmt->execute(array($_GET['type']));
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } else {
    //         $stmt = $dbh->prepare("SELECT E.ID, E.email, E.firstName, E.lastName, E.type, D.ID as DepartmentID, D.Name as DepartmentName, E.contactNumber FROM Employee E LEFT JOIN Department D ON E.departmentID=D.ID ORDER BY E." . $orderBy . " " . $orderDirection);
    //         $stmt->execute();
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     }
    // }
    $params = [];
    if (isset($_GET['type'])) {
        $params[':type'] = $_GET['type'];
    }
    if (isset($_GET['q'])) {
        $params[':q'] = $_GET['q'];
    }
    if (isset($_GET['department_id'])) {
        $params[':department_id'] = $_GET['department_id'];
    }
    $stmt = $dbh->prepare("SELECT E.ID, E.email, E.firstName, E.lastName, E.type, D.ID as DepartmentID, D.Name as DepartmentName, E.contactNumber FROM Employee E LEFT JOIN Department D ON E.departmentID=D.ID " . (count($_GET) ? " WHERE " : "") . (isset($_GET['department_id']) ? "E.departmentID=:department_id" : "") . (isset($_GET['department_id'], $_GET['type']) ? " AND " : "") . (isset($_GET['type']) ? "E.type=:type" : "") . (isset($_GET['type'], $_GET['q']) || isset($_GET['department_id'], $_GET['q']) ? " AND " : "") . (isset($_GET['q']) ? "E.lastName LIKE CONCAT('%', :q,'%')" : "") . " ORDER BY E." . $orderBy . " " . $orderDirection);
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
        $stmt = $dbh->prepare('SELECT * FROM Employee WHERE ID=:id');
        $stmt->execute([':id' => $DELETE['id']]);
        if ($stmt->rowCount() > 0) {
            $dbh->prepare('DELETE FROM Employee WHERE id=?')->execute([$DELETE['id']]);

            $response['status'] = 'The employee has been deleted';
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'The employee that you are trying to delete does not exist!';
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
