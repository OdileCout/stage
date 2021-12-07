<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/MotCle.php');
include_once('../../models/Cadre_MotCle.php');

    try {
        var_dump($_POST['idCadre']);
        var_dump($_POST['idMotCle']);
        $cadreDeTravail = new CadreDeTravail();
        $motcle = new Motcle();
        $InserIdMotcle = new Cadre_MotCle();
        $idCadre = $cadreDeTravail->setId($_POST['idCadre']);
        $recupIdCadre = $cadreDeTravail->getId();
        // $id = $document->setId($_POST['idDocument']);
         $recupIdMotcle = $_POST['idMotCle'];
        var_dump($recupIdMotcle );
        $listeAllMotcle = $InserIdMotcle->deletedAllKeyWord($recupIdMotcle ,$recupIdCadre);
        header('Content-Type: application/json');
         echo json_encode($listeAllMotcle);
        } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        }