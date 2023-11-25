<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (count($_GET) > 0) {
        $response['results'] = [];
        $response['status'] = 'No parameters allowed';

        echo json_encode($response);
        http_response_code(400);
        exit;
    }

    $stmt = $dbh->prepare('SELECT Id, Name FROM Department');
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
