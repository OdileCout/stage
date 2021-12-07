<?php
include_once('../../models/Documents.php');
try {
    $DeletedDocs = new Documents();
    $id = $_POST['id'];
    $DeletedDocs->setId($id);
    $listeDeleted = $DeletedDocs->DeletedDocsAll();
    header('Content-Type: application/json');
    echo json_encode( $listeDeleted);
} catch (Exception $e) {
    http_response_code(500);
}