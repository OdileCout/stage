<?php
include_once('../../models/MotCle.php');

try {
    $insertMotCle = new Motcle();
    if (!isset($_POST['nomMotCle']) || empty($_POST['nomMotCle'])) throw new Exception("Variable nomMotCle n'existe pas");
    $nom = $_POST['nomMotCle'];
    $insertMotCle->setNom($nom);
    //on verifie si le nom du mot clé existe déjà
    $exists = $insertMotCle->isExists();
    //S'il n'existe pas 
    if($exists->NomExists) throw new Exception("le nom existe déjà");
    $liste = $insertMotCle->insertMotCle();
    echo json_encode( $liste);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}


