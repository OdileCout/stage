<?php
include_once('../../models/CadreDeTravail.php');

try {
    $miseAjourDesc = new CadreDeTravail();
    if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    if (!isset($_POST['descri'])) throw new Exception("Variable description n'existe pas");
    $description = $_POST['descri'];
    $id = $_POST['id'];
    var_dump($description);
    $miseAjourDesc->setId($id);
    $miseAjourDesc->setDescription($description);
    $descmettreAjour = $miseAjourDesc->miseAjourDesDonneesDesc($id);
    header('Content-Type: application/json');
    echo json_encode($descmettreAjour);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
