<?php

try {
    if (!isset($_GET['id']) || $_GET['id'] == "") throw new Exception;
    $documentID = $_GET['id'];
    // requete SQL
    $res = "ID du document : $documentID";
    echo json_encode($res);
} catch (Exception $e) {
    http_response_code(500);
}
