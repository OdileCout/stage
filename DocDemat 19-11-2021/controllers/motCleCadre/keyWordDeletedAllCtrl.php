<?php
include_once('../../models/Cadre_MotCle.php');

try {
    $keyWordAllDeleted = new Cadre_MotCle();
    $id = $_POST['idMotcle'];
    $keyWordAllDeleted->setMotCle($id);
    $listeDelete = $keyWordAllDeleted->keyWordDeletedAll();
    header('Content-Type: application/json');
    echo json_encode( $listeDelete);
} catch (Exception $e) {
    http_response_code(500);
}