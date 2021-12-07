<?php
include_once('../../models/IconeDeCadre.php');
try {
    $iconesDeleted = new IconeDesCadres();
    $id = $_POST['id'];
    $iconesDeleted->setId($id);
    $listeDelete = $iconesDeleted->iconeDeleted();
    header('Content-Type: application/json');
    echo json_encode($listeDelete);
} catch (Exception $e) {
    http_response_code(500);
}