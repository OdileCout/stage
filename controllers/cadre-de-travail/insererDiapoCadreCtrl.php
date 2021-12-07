<?php
include_once('../../models/CadreDeTravail.php');
try {
    $InserDiapo = new CadreDeTravail();
//   if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    $diapo = 'diaporama';
    if($_POST['diaporama'] == 'true'){
        $diaporama = 1;
    }else{
        $diaporama = 0;
    }
    $InserDiapo->setDiaporama($diaporama);
    $donneesDiapo = $InserDiapo->getDiaporama();
    $cadreAInserer = $InserDiapo->inserDiapoCadre($diapo, $donneesDiapo);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}