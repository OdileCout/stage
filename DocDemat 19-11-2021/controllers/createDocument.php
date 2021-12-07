<?php

$name = $_POST['name'];
$description = $_POST['description'];
$namdiapoe = $_POST['diapo'];

// requete SQL
$res = "Nom: $name, description: $description, diapo: $diapo";

echo json_encode($res);