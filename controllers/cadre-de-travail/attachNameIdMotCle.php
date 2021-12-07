<?php
include_once('../fonctions/json.php');
include_once('../../models/CadreDeTravail.php');
try {
    $listeNameIdMotCle = new CadreDeTravail(); 
    $id = $_GET['id'];
    // var_dump($id);
    $listeNameIdMotCle->setId($id);
    $donnees = $listeNameIdMotCle->attachNameIdMotCle();
    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}