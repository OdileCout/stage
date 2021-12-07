<?php
include_once './../../models/IconeDeCadre.php';
function sendAsJson($value) {
    header('Content-Type: application/json');
    echo json_encode($value);
}

function sendError($status, $message) {
    http_response_code(500);
    echo $message;
}
try {
    $iconeAInserer = '';
    $listeIcones = new IconeDesCadres();
    if(!isset($_POST['nom'])) throw new Exception('votre champ et vide');
    if(!isset($_FILES['image']))throw new Exception('votre champ et vide'); 
    $name = $_POST['nom'];   
    $_SESSION['nameIcon'] = $name;
    $maxSize = 2097152; // 2097152 correspond à 2 Mega octet
    $extensionsValidate = array('jpg', 'jpeg', 'gif', 'png');
    if ($_FILES['image']['size'] <= $maxSize){
        $extensionUpload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
        if(in_array($extensionUpload, $extensionsValidate)){
            $folderPath = 'tmp/'.$_SESSION['nameIcon'] . '.' . $extensionUpload;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], $folderPath);
            if ($result){
                $listeIcones->setNom($_SESSION['nameIcon']);   
                $listeIcones->setImage($_SESSION['nameIcon'] . '.' . $extensionUpload);
                // $user->avatar = $_SESSION['userId'] . '.' . $extensionUpload;
                $iconAInserer = $listeIcones->insererIconeCadres();
                sendAsJson($iconAInserer);
            } else {
               $errorFile = 'Erreur durant l\'importation de votre photo de profil';
            }
        } else {
          $errorFile = 'Votre photo de profil doit être de format jpg, jpeg, gif ou png';  
        }
    } else {
       $errorFile = 'Votre photo de profil ne doit pas dépasser le 2Mo'; 
    }    
} catch (Exception $e) {
    sendError(500, $e->getMessage());
}
