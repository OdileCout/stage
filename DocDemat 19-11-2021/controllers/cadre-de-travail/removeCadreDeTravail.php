<?php
include_once('../../models/cadreversionvingthuit.php');
// include_once('../../models/CadreDeTravail.php');
try {
    $deleteCadreComplet = new CadreDeTravail();
    $id =$_POST['id'];
    var_dump($id);
    $deleteCadreComplet->setId($id);
    $cadreASupprimer = $deleteCadreComplet->supprimerDesDonneesCadre();
    header('Content-Type: application/json');
    echo json_encode($cadreASupprimer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
