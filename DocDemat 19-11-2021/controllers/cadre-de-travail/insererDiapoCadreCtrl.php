
<?php
include_once('../../models/CadreDeTravail.php');
try {
    $InserDiapo = new CadreDeTravail();
    $nom =($_POST['nom']);//modif pour nom
    if (!isset($_POST['diaporama'])) throw new Exception("Variable diaporama n'existe pas");
    if( $_POST['diaporama'] == 'true'){
        $diaporama = 1;
    }else{
        $diaporama = 0;
    }
    var_dump($diaporama);
    $InserDiapo->setDiaporama($diaporama);
    $donneesDiapo = $InserDiapo->getDiaporama();
    $cadreAInserer = $InserDiapo->inserDiapoCadre($donneesDiapo,$nom);
    header('Content-Type: application/json');
    echo json_encode($cadreAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}

