<?php

include_once('../../models/CadreDeTravail.php');
try {
    $InserNom = new CadreDeTravail();
    if (empty($_POST['nom']) ||$_POST['nom'] == null ) throw new Exception("le nom n'existe pas");
    $nom = 'nom';
    $InserNom->setNom($_POST['nom']);
    $donneesNom = $InserNom->getNom();
    //on verifie si la colonne existe déjà
    $exists = $InserNom->isExists($nom, $donneesNom);
    //S'il n'existe pas 
    if($exists->NomExists) throw new Exception("le nom existe déjà");
        //On insere la colonne (INSERT INTO)
        $cadreAInserer = $InserNom->inserNomCadre($nom, $donneesNom);
        header('Content-Type: application/json');
        echo json_encode($cadreAInserer);
        // $success = 'succès';
        // header('location: AjoutModif.php');
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}