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
    } else {
        $response['results'] = [];
        $response['status'] = 'Please provide only insurance_id & correct scope';
        echo json_encode($response);

        http_response_code(405);
        exit;
    }
} else {
    http_response_code(405);
    exit;
}
