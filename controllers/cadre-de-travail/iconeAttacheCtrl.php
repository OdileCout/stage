<?php
include_once('../fonctions/json.php');
include_once('../../models/CadreDeTravail.php');
try {
    $iconAttacheCadre = new CadreDeTravail(); 
    $id = $_GET['id'];
    // var_dump($id);
    $iconAttacheCadre->setId($id);
    $donnees = $iconAttacheCadre->iconAttacheCadre();
    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}