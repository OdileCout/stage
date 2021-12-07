<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/IconeDeCadre.php');
try {
    $InserIdIcone= new CadreDeTravail();
    $iconeDesCadres = new IconeDesCadres();
    $id = $iconeDesCadres->setId($_POST['idIcone']);
    $toRecoverId = $iconeDesCadres->getId();
    $valColonne = $InserIdIcone->ValDernièreColonne();
    if(isset($valColonne->id_IconeDesCadresDeTravail)) throw new Exception("le cadre a déjà une icone");
    $nbIdIconeAttacher = $InserIdIcone->reattachIcone($toRecoverId);
    header('Content-Type: application/json');
    echo json_encode($nbIdIconeAttacher);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}