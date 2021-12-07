<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/Documents.php');
include_once('../../models/Cadre_Documents.php');

    try {
        $cadreDeTravail = new CadreDeTravail();
        $document = new Documents();
        $InserIdDoc = new Cadre_Document();
        $idCadre = $cadreDeTravail->setId($_POST['idCadre']);
        $recupIdCadre = $cadreDeTravail->getId();
        // var_dump( $recupIdCadre);
        $id = $document->setId($_POST['idDocument']);
        $recupIdDoc = $document->getId();
        // var_dump($recupIdDoc);
        $listeCheckDoc = $InserIdDoc->disaffectDocs($recupIdDoc,$recupIdCadre);
        header('Content-Type: application/json');
        echo json_encode($listeCheckDoc);
        } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        }