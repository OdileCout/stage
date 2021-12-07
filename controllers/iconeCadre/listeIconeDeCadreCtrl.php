<?php
include_once('../../models/IconeDeCadre.php');
try {
    $listeIcones = new IconeDesCadres();
    $liste = $listeIcones->listIconeCadres();
    echo json_encode($liste);
} catch (Exception $e) {
    http_response_code(500);
}
