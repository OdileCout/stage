<?php
include_once('../../models/cadretesff.php');
include_once('../../models/IconeDeCadre.php');

try {
    $miseAjourIcone = new CadreDeTravail();
    $iconeDesCadres = new IconeDesCadres();
    if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    if (!isset($_POST['idIcone'])) throw new Exception("Variable description n'existe pas");
    $idIcone = $_POST['id'];
    $id = $_POST['idIcone'];
    var_dump($idIcone);
    $miseAjourIcone->setId($id);
    $iconeDesCadres->setId($idIcone);
    $icone = $iconeDesCadres->getId();
    $descmettreAjour = $miseAjourIcone->miseAjourIcones($icone);
    header('Content-Type: application/json');
    echo json_encode($descmettreAjour);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}