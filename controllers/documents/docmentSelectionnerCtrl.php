<?php
include_once('../../models/Documents.php');
include_once('../fonctions/json.php');
try {
    $listeDocumentsSelectionner = new Documents(); 
    $donnees = $listeDocumentsSelectionner->listeDesDocumentsSelectionner($_GET['id']);
    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}
