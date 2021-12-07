<?php
include_once('../../models/Cadre_Documents.php');
include_once('../../models/Documents.php');
try {
    $InserIdDocCdr = new Cadre_Document();
    $document = new Documents();
    // var_dump($_POST['iddocument']);
    $id = $document->setId($_POST['idDocument']);
   $rafraichir= $InserIdDocCdr->setRaffraichissement($_POST['raffraichissement']);
    var_dump($rafraichir);
   $priorite= $InserIdDocCdr->setOrdreDePriorite($_POST['ordreDePriorite']);
    var_dump($priorite);
    $recupId = $document->getId();
    var_dump($recupId);
    $nbIdDocAttacher = $InserIdDocCdr->nombreDocumentAttacher();
    var_dump($nbIdDocAttacher->idCadreAttacher);
    //Si le cadre a déjà le 5 documents
    if($nbIdDocAttacher->idCadreAttacher  >= 5) throw new Exception("le cadre a déjà 5 documents");
    $documentAInserer =  $InserIdDocCdr->insertId($recupId);
    header('Content-Type: application/json');
    echo json_encode($documentAInserer);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}


   