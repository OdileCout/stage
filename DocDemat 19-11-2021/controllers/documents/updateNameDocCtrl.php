<?php
include_once('../../models/Documents.php');
include_once('../fonctions/json.php');
try {
    $updateDocument = new Documents();
    if (!isset($_POST['nomDoc'])) throw new Exception("Variable nom n'existe pas");
    if (!isset($_POST['id'])) throw new Exception("Variable id n'existe pas");
    $nom = $_POST['nomDoc'];
    $id = $_POST['id']; 
    var_dump($nom);
    $updateDocument->setId($id);
    $updateDocument->setNom($nom);
    $update = $updateDocument->updateNameDoc();  
    sendAsJson( $update);  
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
