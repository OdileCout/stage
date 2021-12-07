<?php
include_once('../../models/Documents.php');
include_once('../fonctions/json.php');
try {
    $insertDocument = new Documents();
    // if (!isset($_POST['nom'])) throw new Exception("Variable nom n'existe pas");
    // if (!isset($_FILES['chemin'])) throw new Exception("Variable chemin n'existe pas");
    $nom = $_POST['nom']; 
    // $chemin = $_POST['chemin'];
    $types = $_POST['type'];
    $_SESSION['nameDoc'] = $nom;
    $insertDocument->setNom($_SESSION['nameDoc']); 
     //on verifie si le nom existe déjà
     $exists = $insertDocument->isExists();
     //S'il n'existe pas 
     if($exists->NomExists) throw new Exception("le nom existe déjà");
    if(isset($_POST['url'])){
        $url = $_POST['url'];  
        $insertDocument->setChemin($url);
        $insertDocument->setTypes($types);
        $docAInserer = $insertDocument->insertDocument();
        sendAsJson($docAInserer);
    }else if(isset($_FILES['chemin'])){
        $chemin = $_FILES['chemin'];
        $extensionsValidate = array('jpg','jpeg','gif','png','pdf','MP4');
            $extensionUpload = strtolower(substr(strrchr($_FILES['chemin']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValidate)){
                $folder = stristr($_FILES['chemin']['name'], '.', true);
                $folderPath = '../iconeCadre/tmp/documents/'.$folder.'.' .$extensionUpload;
                $result = move_uploaded_file($_FILES['chemin']['tmp_name'], $folderPath);
                if ($result){
                    $insertDocument->setTypes($types);  
                    $insertDocument->setChemin($folder.'.' .$extensionUpload);
                    $docAInserer = $insertDocument->insertDocument();
                    sendAsJson($docAInserer);
                } else {
                    $errorFile = 'Erreur durant l\'importation de votre photo de profil';
                }
            } else {
                $errorFile = 'Votre photo de profil doit être de format jpg, jpeg, gif ou png';  
            }
    }   
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}