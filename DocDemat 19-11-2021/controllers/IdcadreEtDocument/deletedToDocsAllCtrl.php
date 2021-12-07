<?php
include_once('../../models/Cadre_Documents.php');
try {
    $deleteIdDoc = new Cadre_Document();
    $id = $_POST['id'];
    $deleteIdDoc->setIdDocument($id);
    $listeDeleted = $deleteIdDoc->deletedToAllDocs();
    header('Content-Type: application/json');
    echo json_encode( $listeDeleted);
} catch (Exception $e) {
    http_response_code(500);
}