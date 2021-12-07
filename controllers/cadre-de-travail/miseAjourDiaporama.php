<?php
include_once('../../models/CadreDeTravail.php');
try {
    $miseAjourDiapo = new CadreDeTravail();
    if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    if (!isset($_POST['diaporama'])) throw new Exception("Variable diaporama n'existe pas");
    $id = $_POST['id'];
    if($_POST['diaporama'] == 'true'){
        $diaporama = 1;
    }else{
        $diaporama = 0;
    }
    var_dump($diaporama);
    $miseAjourDiapo->setId($id);
    $miseAjourDiapo->setDiaporama($diaporama);
    $diapocmettreAjour = $miseAjourDiapo->miseAjourDesDonneesDiapo($id);
    header('Content-Type: application/json');
    echo json_encode($diapocmettreAjour);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
