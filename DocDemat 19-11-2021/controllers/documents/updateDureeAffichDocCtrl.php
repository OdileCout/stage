<?php
include_once('../../models/Cadre_Documents.php');
include_once('../fonctions/json.php');
try {
    $updateDocument = new Cadre_Document();
    if (!isset($_POST['id'])) throw new Exception("Variable id n'existe pas");
    if (!isset($_POST['DureeDoc'])) throw new Exception("Variable durée n'existe pas");
    if (!isset($_POST['idCadre'])) throw new Exception("Variable id n'existe pas");
    $id = $_POST['id'];
    $nom = $_POST['DureeDoc']; 
    $idCadre = $_POST['idCadre'];
    $updateDocument->setIdDocument($id);
    $updateDocument->setDureeAffichage($nom);
    $updateDocument->setIdCadresDeTravail($idCadre);
    $update = $updateDocument->updateDureeAfficheDoc();  
    sendAsJson($update);  
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
