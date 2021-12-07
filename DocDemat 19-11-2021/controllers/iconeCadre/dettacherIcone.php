<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/IconeDeCadre.php');
    try {
      
        $cadreDeTravail = new CadreDeTravail();
        $icone = new IconeDesCadres();
        $idCadre = $cadreDeTravail->setId($_POST['id']);
        $recupIdCadre = $cadreDeTravail->getId();
        
        // var_dump( $recupIdCadre);
        // $id = $icone->setId($_POST['idIcone']);
        // $recupIdicone =  $icone->getId();
        // var_dump($recupIdDoc);
        $listeCheckIcone = $cadreDeTravail->disaffectIcone($recupIdCadre);
        header('Content-Type: application/json');
        echo json_encode($listeCheckIcone);
        } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        }