<?php
include_once('inc/Database.php');
include_once('Documents.php');
class Cadre_Document extends Database{
    private $id_Document = null;
    private $id_CadresDeTravail = null;
    private $raffraichissement;
    private $ordreDePriorite;
    private $dureeAffichage;
    private $dateDeFinValidite;
    private $dateDebutDeValidite;

     public function getIdDocument(){
         return $this->id_Document;
     }
     public function setIdDocument($id_Document){
         $this->id_Document = $id_Document;
     }
     public function getIdCadresDeTravail(){
         return $this->id_CadresDeTravail;
     }
     public function setIdCadresDeTravail($id_CadresDeTravail){
         $this->id_CadresDeTravail = $id_CadresDeTravail;
     }
    public function getRaffraichissement(){
        return $this->raffraichissement;
    }
    public function setRaffraichissement($raffraichissement){
        $this->raffraichissement= $raffraichissement;
    } 
    
    public function getOrdreDePriorite(){
        return $this->ordreDePriorite;
    }
    public function setOrdreDePriorite($ordreDePriorite){
        $this->ordreDePriorite=$ordreDePriorite;
    }
    public function getDureeAffichage(){
        return $this->dureeAffichage;
    }
    public function setDureeAffichage($dureeAffichage){
        $this->dureeAffichage = $dureeAffichage;
    }
    public function getDateDebutDeValidite(){
        return $this->dateDebutDeValidite;
    }
    public function setDateDebutDeValidite($dateDebutDeValidite){
        $this->dateDebutDeValidite = $dateDebutDeValidite;
    } 
    public function getDateDeFinValidite(){
        return $this->dateDeFinValidite;
    }
    public function setDateDeFinValidite($dateDeFinValidite){
        $this->dateDeFinValidite = $dateDeFinValidite;
    }
    /******************* */
    public function nombreDocumentAttacher(){
        $query = 'SELECT COUNT(id_CadresDeTravail) AS idCadreAttacher 
                 FROM CAF_DocDemat.cadre_Document WHERE id_CadresDeTravail = (SELECT maxid FROM (SELECT MAX(id) AS maxid
                 FROM CAF_DocDemat.CadresDeTravail) AS tempo)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->execute();
        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }
    /**
     * Attache des document sur le dernier cadre créer
     * @return un boolean
     */
    public function insertId($recupId){
        // nom,chemin,dureeAffichage,dateDeFinDeValidite,dateDeDebutDeValidite,
        $query = 'INSERT INTO cadre_Document (id_document, id_CadresDeTravail,raffraichissement,ordreDePriorite) 
                VALUES ((SELECT id FROM Document WHERE id =:idDocument), 
                (SELECT id FROM CadresDeTravail WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
                FROM CadresDeTravail) AS tempo)),:raffraichissement,:ordreDePriorite)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':idDocument', $recupId, PDO::PARAM_INT);
        $pdoStatment->bindValue(':raffraichissement',$this->getRaffraichissement(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':ordreDePriorite',$this->getOrdreDePriorite(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
     /**
      * Fonction qui compte le nombre des document rattacher à un cadre (par l'id du cadre)
      * @return un objet
      */
     public function nombreDocumentAttacherAuCadre($theIdCatre){
        $query = 'SELECT COUNT(id_CadresDeTravail) AS idCadreAttacherAuDoc 
                 FROM cadre_Document WHERE id_CadresDeTravail = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $theIdCatre, PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }
    /**
     * Met à jour un cadre, attache des documents sur un cadre créer (avec l'id de cadre)
     * @return un boolean
     */
    public function attacheDesDocuments($theId, $theIdCatre){
        // nom,chemin,dureeAffichage,dateDeFinDeValidite,dateDeDebutDeValidite,
        $query = 'INSERT INTO cadre_Document (id_document, id_CadresDeTravail,raffraichissement,ordreDePriorite, dureeAffichage, dateDebutDeValidite, dateDeFinValidite) 
        VALUES (:idDocument,:idCadre ,:raffraichissement,:ordreDePriorite,:dureeAffichage, :dateDebutDeValidite, :dateDeFinValidite)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':idDocument', $theId, PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $theIdCatre, PDO::PARAM_INT);
        $pdoStatment->bindValue(':raffraichissement',$this->getRaffraichissement(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':ordreDePriorite',$this->getOrdreDePriorite(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':dureeAffichage',$this->getDureeAffichage(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':dateDebutDeValidite',$this->getDateDebutDeValidite(),PDO::PARAM_STR);
        $pdoStatment->bindValue(':dateDeFinValidite',$this->getDateDeFinValidite(),PDO::PARAM_STR);
        return $pdoStatment->execute();
    }
        /**
     * Une fonction qui fait du changement sur le document_cadre
     * @return un objet
     */
    public function updateDureeAfficheDoc()
    {
        $sql='UPDATE cadre_Document 
            SET dureeAffichage =:dureeAffichage
            WHERE id_document = :id  AND id_CadresDeTravail = :idCadre';
        $pdoStatment = $this->db->prepare($sql);
        $pdoStatment->bindValue(':dureeAffichage', $this->getDureeAffichage(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getIdDocument(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $this->getIdCadresDeTravail(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * Une fonction qui fait du changement sur de début de validité le document_cadre
     * @return un objet
     * UPDATE cadre_Document 
     * SET dateDebutDeValidite = '2020-01-01'
     * WHERE id_document = 15 AND id_CadresDeTravail = 2
     */
    public function updateDateDVDoc()
    {
        $sql='UPDATE cadre_Document 
            SET dateDebutDeValidite =:dateDebutDeValidite
            WHERE id_document = :id AND id_CadresDeTravail = :idCadre';
        $pdoStatment = $this->db->prepare($sql);
        // var_dump($this->getDateDebutDeValidite());
        $pdoStatment->bindValue(':dateDebutDeValidite', $this->getDateDebutDeValidite(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getIdDocument(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $this->getIdCadresDeTravail(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * Une fonction qui fait du changement sur de début de validité le document_cadre
     * @return un objet
     */
    public function updateDateDFDoc()
    {
        $sql='UPDATE cadre_Document 
            SET dateDeFinValidite =:dateDeFinValidite
            WHERE id_document = :id AND id_CadresDeTravail = :idCadre';
        $pdoStatment = $this->db->prepare($sql);
        // var_dump($this->getDateDebutDeValidite());
        $pdoStatment->bindValue(':dateDeFinValidite', $this->getDateDeFinValidite(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getIdDocument(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $this->getIdCadresDeTravail(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * Une fonction qui fait du changement sur de début de validité le document_cadre
     * @return un objet
     */
    public function updateReffreshDoc()
    {
        $sql='UPDATE cadre_Document 
            SET raffraichissement =:raffraichissement
            WHERE id_document = :id AND id_CadresDeTravail = :idCadre';
        $pdoStatment = $this->db->prepare($sql);
        // var_dump($this->getDateDebutDeValidite());
        $pdoStatment->bindValue(':raffraichissement', $this->getRaffraichissement(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getIdDocument(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $this->getIdCadresDeTravail(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * Une fonction qui fait du changement sur de début de validité le document_cadre
     * @return un objet
     */
    public function updateOrderDoc()
    {
        $sql='UPDATE cadre_Document 
            SET ordreDePriorite =:ordreDePriorite
            WHERE id_document = :id AND id_CadresDeTravail = :idCadre';
        $pdoStatment = $this->db->prepare($sql);
        // var_dump($this->getDateDebutDeValidite());
        $pdoStatment->bindValue(':ordreDePriorite', $this->getOrdreDePriorite(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getIdDocument(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $this->getIdCadresDeTravail(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
    /**
     * fonction qui delete les docs au check dans la base de données (dans tab doc)
     * @return boolean
     */
    public function disaffectDocs($idDocs,$idCadre)
    {
        $query = 'DELETE FROM `cadre_Document` WHERE id_document = :id_document AND id_CadresDeTravail = :id_CadresDeTravail';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id_document', $idDocs, PDO::PARAM_INT);
        // var_dump($idDocs);
        $pdoStatment->bindValue(':id_CadresDeTravail',$idCadre, PDO::PARAM_INT);
        // var_dump($idCadre);
        return $pdoStatment->execute();
    }
    /**
     * fonction qui delete les docs au check dans la base de données (dans tab doc)
     * @return boolean
     */
    public function deletedAllDocs($idDocs,$idCadre)
    {
        var_dump($idDocs);
        $query = 'DELETE FROM `cadre_Document` WHERE id_document IN ('.$idDocs.') AND id_CadresDeTravail = :id_CadresDeTravail';
        var_dump($query);
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id_CadresDeTravail',$idCadre, PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
}