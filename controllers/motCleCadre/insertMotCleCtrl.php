<?php
include_once('../../models/MotCle.php');

try {
    $insertMotCle = new Motcle();
    if (!isset($_POST['nomMotCle']) || empty($_POST['nomMotCle'])) throw new Exception("Variable nomMotCle n'existe pas");
    $nom = $_POST['nomMotCle'];
    $insertMotCle->setNom($nom);
    $liste = $insertMotCle->insertMotCle();
    echo json_encode( $liste);
} catch (Exception $e) {
    http_response_code(500);
}