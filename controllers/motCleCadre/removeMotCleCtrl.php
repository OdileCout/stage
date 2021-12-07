<?php
include_once('../../models/Rattacher.php');
function sendAsJson($value) {
    header('Content-Type: application/json');
    echo json_encode($value);
}
function sendError($status, $message) {
    http_response_code(500);
    echo $message;
}
try {
    $deleteIdCadreMotcle = new Cadre_MotCle();
    $id = $_POST['id'];
    $deleteIdCadreMotcle->setid($id);
    $liste = $deleteIdCadreMotcle->deleteIdCadreMotcle();
    echo json_encode( $liste);
} catch (Exception $e) {
    http_response_code(500);
}