<?php
include_once('../../models/cadretesff.php');
try {
$listeCadres = new CadreDeTravail();
$liste = $listeCadres->listCadre();
echo json_encode($liste);
// var_dump($liste);
} catch (Exception $e) {
    http_response_code(500);
}