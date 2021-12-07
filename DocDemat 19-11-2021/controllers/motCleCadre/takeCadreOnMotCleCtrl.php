<?php
include_once('../../models/MotCle.php');

try {
    $takeCadre = new Motcle();
    $nom = $_POST['nomMotcle'];
    // var_dump($nom);
    $takeCadre->setNom($nom);
    $listeCadre = $takeCadre->takeCadreOnMotcle();
    header('Content-Type: application/json');
    echo json_encode( $listeCadre);
} catch (Exception $e) {
    http_response_code(500);
}