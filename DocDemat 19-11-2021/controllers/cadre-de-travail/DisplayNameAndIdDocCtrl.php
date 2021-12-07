<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/Documents.php');

try {
    $listeCadreName = new CadreDeTravail(); 
    $Docs= new Documents();
    $id=$_POST['id'];
    $Docs->setId($id);
    $recoverDoc=$Docs->getId();
    $donnees = $listeCadreName->recoverNameCadreAndBindId($recoverDoc);
    header('Content-Type: application/json');
    echo json_encode( $donnees);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}