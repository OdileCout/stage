<?php
include_once('../../models/Cadre_MotCle.php');
include_once('../../models/MotCle.php');
include_once('../../models/CadreDeTravail.php');

try {
    $InserIdMcCdr = new Cadre_MotCle();
    $motCle = new Motcle();
    $cadre = new CadreDeTravail();
    // var_dump($_POST['idmotCadre']);
    $idmotCadre = $_POST['idmotCadre'];
    $idCadre = $cadre->setId($idmotCadre);
    $recupIdCadre = $cadre->getId();
    $id = $motCle->setId($_POST['id']);
    $recupId = $motCle->getId();
    // var_dump($_POST['id']);
    $listeCheckInDelete = $InserIdMcCdr->keyWordDeletedCheckIn($recupId,$recupIdCadre);
    header('Content-Type: application/json');
    echo json_encode($listeCheckInDelete);
} catch (Exception $e) {
    http_response_code(500);
}