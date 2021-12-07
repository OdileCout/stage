<?php
include_once('../../models/CadreDeTravail.php');
include_once('../../models/IconeDeCadre.php');
try {
    $miseAjourIcone = new CadreDeTravail();
    $iconeDesCadres = new IconeDesCadres();
    if (!isset($_POST['idIcone'])) throw new Exception("Variable description n'existe pas");
    $idIcone = $_POST['idIcone'];
    var_dump($idIcone);
    $iconeDesCadres->setId($idIcone);
    $idIcone = $miseAjourIcone->getId();
    $cadremettreAjour = $iconeDesCadres->miseAjourIconePourIcones($idIcone);
    header('Content-Type: application/json');
    echo json_encode($cadremettreAjour);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}