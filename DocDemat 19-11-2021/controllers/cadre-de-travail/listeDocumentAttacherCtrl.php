<?php
include_once('../../models/CadreDeTravail.php');
include_once('../fonctions/json.php');
try {
    $listeDocumentsAttacherAuCadre = new CadreDeTravail(); 
    $idCadre = $_GET['id'];
    // var_dump($idCadre);
    $listeDocumentsAttacherAuCadre->setId($idCadre);
    $donnees = $listeDocumentsAttacherAuCadre->listeDesDocumentsAttacher();
    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}