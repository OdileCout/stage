<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/Documents.php');
include_once('../../models/Cadre_Documents.php');

    try {
        var_dump($_POST['idCadre']);
        var_dump($_POST['idDocument']);
        $cadreDeTravail = new CadreDeTravail();
        $document = new Documents();
        $InserIdDoc = new Cadre_Document();
        $idCadre = $cadreDeTravail->setId($_POST['idCadre']);
        $recupIdCadre = $cadreDeTravail->getId();
        // $id = $document->setId($_POST['idDocument']);
         $recupIdDoc = $_POST['idDocument'];
        var_dump($recupIdDoc);
        $listeAllDoc = $InserIdDoc->deletedAllDocs($recupIdDoc,$recupIdCadre);
        header('Content-Type: application/json');
         echo json_encode($listeAllDoc);
        } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        }