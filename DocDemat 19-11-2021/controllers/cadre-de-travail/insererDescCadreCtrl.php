<?php
include_once('../../models/CadreDeTravail.php');
try {
    $InserDesc = new CadreDeTravail();
    // if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    $nom =($_POST['nom']);
    // $desc =($_POST['description']);
    $InserDesc->setDescription($_POST['description']);
    $donneesDesc = $InserDesc->getDescription();
    $cadreAInserer = $InserDesc->inserDescCadre($donneesDesc,$nom);
    header('Content-Type: application/json');
    echo json_encode($cadreAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}