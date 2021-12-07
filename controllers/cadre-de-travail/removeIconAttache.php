<?php
include_once('../../models/CadreDeTravail.php');
try {
    $iconesDeleted = new CadreDeTravail();
    $id =$_POST['id_IconeDesCadresDeTravail'];
    var_dump($id);
    $iconesDeleted->setId($id);
    $listeDelete = $iconesDeleted->iconeCadreDeleted();
    header('Content-Type: application/json');
    echo json_encode($listeDelete);
} catch (Exception $e) {
    http_response_code(500);
}