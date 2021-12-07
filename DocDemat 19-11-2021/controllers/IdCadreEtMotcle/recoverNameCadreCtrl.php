<?php
include_once('../../models/Cadre_MotCle.php');
// A METTRE DANS UN FICHIER GLOBAL
function sendAsJson($value) {
    header('Content-Type: application/json');
    echo json_encode($value);
}

function sendError($status, $message) {
    http_response_code(500);
    echo $message;
}

try {
    $listeCadreName = new Cadre_MotCle(); 
    $motCle= new MotCle();
    $id=$_POST['id'];
    $motCle->setId($id);
    $recoverMotCle=$motCle->getId();
    $donnees = $listeCadreName->recoverNameCadreAndKeyWordIdI($recoverMotCle);

    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}