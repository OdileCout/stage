<?php
include_once('../../models/Documents.php');
include_once('../fonctions/json.php');
try {
    $insertDocument = new Documents();
    if (!isset($_POST['nom'])) throw new Exception("Variable nom n'existe pas");
    if (!isset($_FILES['chemin'])) throw new Exception("Variable chemin n'existe pas");
    var_dump($_POST);
    $nom = $_POST['nom']; 
    $chemin = $_FILES['chemin'];
    $_SESSION['nameDoc'] = $nom;
    // $maxSize = 30216433; // 2097152 correspond à 2 Mega 
    $extensionsValidate = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'MP4');
    // if ($_FILES['chemin']['size'] <= $maxSize){
        $extensionUpload = strtolower(substr(strrchr($_FILES['chemin']['name'], '.'), 1));
        if(in_array($extensionUpload, $extensionsValidate)){
            $folderPath = '../iconeCadre/tmp/'.$_SESSION['nameDoc'] . '.' . $extensionUpload;
            $result = move_uploaded_file($_FILES['chemin']['tmp_name'], $folderPath);
            if ($result){
                $insertDocument->setNom($_SESSION['nameDoc']);   
                $insertDocument->setChemin($_SESSION['nameDoc'] . '.' . $extensionUpload);
                $docAInserer = $insertDocument->insertDocument();
                sendAsJson($docAInserer);
            } else {
               $errorFile = 'Erreur durant l\'importation de votre photo de profil';
            }
        } else {
          $errorFile = 'Votre photo de profil doit être de format jpg, jpeg, gif ou png';  
        }
    // } else {
    //    $errorFile = 'Votre photo de profil ne doit pas dépasser le 2Mo'; 
    // }    
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}