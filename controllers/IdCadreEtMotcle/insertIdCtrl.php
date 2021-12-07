<?php
include_once('../../models/Cadre_MotCle.php');
include_once('../../models/MotCle.php');
include_once('../../models/CadreDeTravail.php');
try {
    $InserIdMcCdr = new Cadre_MotCle();
    $motCle = new Motcle();
    $cadre = new CadreDeTravail();
    // var_dump($_POST['idmotcle']);
    $idmotCadre = $_POST['idmotCadre'];
    $idCadre = $cadre->setId($idmotCadre);
    $recupIdCadre = $cadre->getId();
    $id = $motCle->setId($_POST['idmotcle']);
    $recupId = $motCle->getId();
    // var_dump($recupId);
    // $nbIdCadreAttacher = $InserIdMcCdr->nombreCadreAttacher();
    // var_dump($nbIdCadreAttacher->idCadreAttacher);
    // //Si le cadre a déjà quatre mot clé 
    // if($nbIdCadreAttacher->idCadreAttacher >= 4) throw new Exception("le cadre a déjà 4 mot clé");
    $cadreAInserer = $InserIdMcCdr->insertId($recupId, $recupIdCadre);
    header('Content-Type: application/json');
    echo json_encode($cadreAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}