<?php
include_once('../../models/CadreDeTravail.php');
try {
$listeCadresIcones = new CadreDeTravail();
$listes = $listeCadresIcones->listCadreAvecIcone();
echo json_encode($listes);
} catch (Exception $e) {
    http_response_code(500);
}