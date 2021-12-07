<?php
include_once('../../models/MotCle.php');

try {
    $keyWordDeleted = new MotCle();
    $id = $_POST['id'];
    $keyWordDeleted->setId($id);
    $listeDelete = $keyWordDeleted->keyWordDeleted();
    header('Content-Type: application/json');
    echo json_encode( $listeDelete);
} catch (Exception $e) {
    http_response_code(500);
}