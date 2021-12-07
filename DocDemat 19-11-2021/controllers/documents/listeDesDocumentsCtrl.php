<?php
include_once('../../models/Documents.php');
include_once('../fonctions/json.php');
try {
    $listeDocuments = new Documents(); 
    $donnees = $listeDocuments->listeDesDocuments();
    sendAsJson($donnees);
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}