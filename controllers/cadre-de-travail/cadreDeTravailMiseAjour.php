<?php
include_once('../../models/cadretesff.php');
try {
    $listeCadres = new CadreDeTravail();
    if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    if (!isset($_POST['nom'])) throw new Exception("Variable nom n'existe pas");
    if (!isset($_POST['description'])) throw new Exception("Variable description n'existe pas");
    if (!isset($_POST['diaporama'])) throw new Exception("Variable diaporama n'existe pas");
    // if (!isset($_POST['idIcone'])) throw new Exception("Variable idIcone n'existe pas");
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    var_dump($nom);
    $description = $_POST['description'];
    var_dump( $description);
    // $idIcone = $_POST['idIcone'];
    // var_dump($idIcone);
    
    if($_POST['diaporama'] == 'true'){
        $diaporama = 1;
    }else{
        $diaporama = 0;
    }

    var_dump( $diaporama );
    $listeCadres->setId($id);
    $listeCadres->setNom($nom);
    $listeCadres->setDescription($description);
    $listeCadres->setDiaporama($diaporama);
    // $listeCadres->setIdIcone($idIcone);
    $cadreAInserer = $listeCadres->miseAjourDesDonnees();
    header('Content-Type: application/json');
    echo json_encode($cadreAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
