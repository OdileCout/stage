<?php
include_once('../../models/MotCle.php');

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
    $listeMotCle = new Motcle(); 
    $donnees = $listeMotCle->listIMotCle();
    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}