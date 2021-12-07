<?php
include_once('../../models/CadreDeTravail.php');
try {
    $cadreDeTravail = new CadreDeTravail();
    $cadreDeTravail->setId($_POST['id']);
    $motcleAInserer = $cadreDeTravail->afficherDocumentAttacherCadre();
    header('Content-Type: application/json');
    echo json_encode($motcleAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}