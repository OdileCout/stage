<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/Documents.php');
include_once('../../models/Cadre_Documents.php');
try {
    $cadreDeTravail = new CadreDeTravail();
    $document = new Documents();
    $InserIdDocCdr = new Cadre_Document();
    if(!isset($_POST['idCadre'])) throw new Exception('votre idCadre et vide');
    if(!isset($_POST['idDocument']))throw new Exception('votre champ et vide');
    if(!isset($_POST['raffraichissement'])) throw new Exception('votre idCadre et vide');
    if(!isset($_POST['ordreDePriorite']))throw new Exception('votre champ et vide');
    if (!isset($_POST['dureeAffichage'])) throw new Exception("Variable dureeAffichage n'existe pas");
    if (!isset($_POST['dateDeFinValidite'])) throw new Exception("Variable dateDeFinValidite n'existe pas");
    if (!isset($_POST['dateDebutDeValidite'])) throw new Exception("Variable dateDebutDeValidite n'existe pas");
    $idCadre = $cadreDeTravail->setId($_POST['idCadre']);
    $theIdCatre = $cadreDeTravail->getId();
    $id = $document->setId($_POST['idDocument']);
    $theId = $document->getId();
    $rafraichir = $InserIdDocCdr->setRaffraichissement($_POST['raffraichissement']);
    $priorite = $InserIdDocCdr->setOrdreDePriorite($_POST['ordreDePriorite']);
    $dureeAffichage = $_POST['dureeAffichage'];
    $InserIdDocCdr->setDureeAffichage($dureeAffichage);
    $dateDebutDeValidite = $_POST['dateDebutDeValidite'];
    $InserIdDocCdr->setDateDebutDeValidite($dateDebutDeValidite);
    $dateDeFinValidite = $_POST['dateDeFinValidite'];
    $InserIdDocCdr->setDateDeFinValidite($dateDeFinValidite);
    $nbIdDocAttacher = $InserIdDocCdr->nombreDocumentAttacherAuCadre($theIdCatre);
    //Si le cadre a déjà le 5 documents
    if($nbIdDocAttacher->idCadreAttacherAuDoc >= 5) throw new Exception("le cadre a déjà 5 documents");
    $documentAInserer = $InserIdDocCdr->attacheDesDocuments($theId, $theIdCatre);
    header('Content-Type: application/json');
    echo json_encode($documentAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}