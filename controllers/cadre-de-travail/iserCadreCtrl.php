<?php
include_once('../../models/CadreDeTravails.php');
try {
    $cadreInser = new CadreDeTravail();
    // if (!isset($_POST['id'])) throw new Exception("l'id n'existe pas");
    // if (!isset($_POST['nom'])) throw new Exception("Variable nom n'existe pas");
    // if (!isset($_POST['description'])) throw new Exception("Variable description n'existe pas");
    // if (!isset($_POST['diaporama'])) throw new Exception("Variable diaporama n'existe pas");
    // if (!isset($_POST['idIcone'])) throw new Exception("Variable idIcone n'existe pas");
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    if($_POST['diaporama'] == 'true'){
        $diaporama = 1;
    }else{
        $diaporama = 0;
    }
    $motClesCadre = $_POST['motCles'];
    $documentsCadre = $_POST['documents'];
    $iconeCadre = $_POST['icone'];

    $cadreInser->setNom($nom);
    $cadreInser->setDescription($description);
    $cadreInser->setDiaporama($diaporama);
    $cadreAInserer = $cadreInser->miseAjourDesDonnees($motClesCadre, $documentsCadre, $iconeCadre );
    header('Content-Type: application/json');
    echo json_encode($cadreAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
