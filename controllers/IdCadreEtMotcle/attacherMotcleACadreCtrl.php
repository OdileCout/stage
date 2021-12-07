<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/MotCle.php');
include_once('../../models/Cadre_MotCle.php');
try {
    $cadreDeTravail = new CadreDeTravail();
    $motCle = new Motcle();
    $InserIdMotcleCdr = new Cadre_MotCle();
    $idCadre = $cadreDeTravail->setId($_POST['idCadre']);
    $theIdCadre = $cadreDeTravail->getId();
    $id = $motCle->setId($_POST['idMotcle']);
    $theId = $motCle->getId();
    $nbIdMotcleAttacher = $InserIdMotcleCdr->nombreMotcleAttacherAuCadre($theIdCadre);
    var_dump($nbIdDocAttacher);
    //Si le cadre a déjà le 5 documents
    if($nbIdMotcleAttacher->idCadreAttacherAuMotcle >= 5) throw new Exception("le cadre a déjà 5 documents");
    $motcleAInserer = $InserIdMotcleCdr->attacheDesMotcles($theId, $theIdCadre);
    header('Content-Type: application/json');
    echo json_encode($motcleAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}