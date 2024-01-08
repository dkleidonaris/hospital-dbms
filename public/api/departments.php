<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'ID';
    $orderDirection = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'ASC';
    if (isset($_GET['q'])) {
        $stmt = $dbh->prepare("SELECT ID, Name FROM Department WHERE Name LIKE CONCAT('%',?,'%')" . " ORDER BY " . $orderBy . " " . $orderDirection);
        $stmt->execute(array($_GET['q']));
    } else {
        $stmt = $dbh->prepare("SELECT ID, Name FROM Department ORDER BY " . $orderBy. " " . $orderDirection);
        $stmt->execute();
    }

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
        $stmt = $dbh->prepare('SELECT * FROM Department WHERE ID=:id');
        $stmt->execute([':id' => $DELETE['id']]);
        if ($stmt->rowCount() > 0) {
            $dbh->prepare('DELETE FROM Department WHERE id=?')->execute([$DELETE['id']]);

            $response['status'] = 'The department has been deleted';
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'The department that you are trying to delete does not exist!';
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
} else {
    $response['results'] = [];
    $response['status'] = 'Not allowed!';
    echo json_encode($response);
    http_response_code(405);
    exit;
}
