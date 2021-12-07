<?php
include_once('../../models/CadreDeTravail.php');
try {
    $InserDesc = new CadreDeTravail();
    // if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    $desc = 'description';
    $InserDesc->setDescription($_POST['description']);
    $donneesDesc = $InserDesc->getDescription();
    $cadreAInserer = $InserDesc->inserDescCadre($desc, $donneesDesc);
    header('Content-Type: application/json');
    echo json_encode($cadreAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}