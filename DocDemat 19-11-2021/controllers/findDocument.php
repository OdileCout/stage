<?php

$documentID = $_GET['id'];

// requete SQL

$res = "ID du document : $documentID";

echo json_encode($res);