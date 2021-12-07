<?php
include_once('../../models/Cadre_Documents.php');
include_once('../fonctions/json.php');
try {
    $updateDocument = new Cadre_Document();
    if (!isset($_POST['raffraichDoc'])) throw new Exception("Variable Date de début n'existe pas");
    if (!isset($_POST['id'])) throw new Exception("Variable id n'existe pas");
    if (!isset($_POST['idCadre'])) throw new Exception("Variable id n'existe pas");
    $nom = $_POST['raffraichDoc'];
    $id = $_POST['id'];
    $idCadre = $_POST['idCadre'];
    $updateDocument->setIdDocument($id);
    $updateDocument->setRaffraichissement($nom);
    $updateDocument->setIdCadresDeTravail($idCadre);
    $update = $updateDocument->updateReffreshDoc();  
    sendAsJson( $update);  
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}