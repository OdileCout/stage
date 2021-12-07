<?php
include_once('inc/Database.php');
class Documents extends Database{
    private $id = null;
    private $nom ;
    private $chemin;
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getNom(){
        return $this->nom;
    }
    public function setNom($nom){
        $this->nom = $nom;
    } 
    public function getChemin(){
        return $this->chemin;
    }
    public function setChemin($chemin){
        $this->chemin = $chemin;
    }

    /**
     * Une fonction qui retourne une liste des documents dans la base de données
     * @return objet
     */
    public function listeDesDocuments(){
        $query = 'SELECT id, nom, chemin FROM Document  ORDER BY Document.nom DESC';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * Une fonction qui retourne une liste des documents selectionner pour affecter au cadre de travail
     * @return objet
     */
    public function listeDesDocumentsSelectionner($ids){
        $query = 'SELECT id, nom FROM Document WHERE id IN ('.$ids.')';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * Une fonction qui insert un icon dans la base de données
     * @return boolean
     */
    public function insertDocument($duree){
    // $date = date('Y-m-d');
        $query = 'INSERT INTO Document (nom,chemin) 
                  VALUES(:nom,:chemin)'; 
        $pdoStatment = $this->db->prepare($query); 
        $pdoStatment->bindValue(':nom',$this->getNom(),PDO::PARAM_STR);
        $pdoStatment->bindValue(':chemin',$this->getChemin(),PDO::PARAM_STR);
        return $pdoStatment->execute();
    }
    /**
     * Une fonction qui fait du changement sur le document
     * @return un objet
     */
    public function updateNameDoc()
    {
        $sql='UPDATE Document 
            SET nom =:nom
            WHERE id = :id';
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
    /**
     * Une fonction qui fait du changement sur de fin de validité le document
     * @return un objet
     */
    public function updateDateDFDoc()
    {
        $sql='UPDATE Document 
            SET dateDeFinValidite =:dateDeFinValidite
            WHERE id = :id';
        $pdoStatment = $this->db->prepare($sql);
        var_dump($this->getDateDebutDeValidite());
        $pdoStatment->bindValue(':dateDeFinValidite', $this->getDateDeFinValidite(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
    /**
     * fonction qui delete les id et du document dans la base de données
     * @return boolean
     */
    public function DeletedDocs(){
        $query = 'DELETE FROM Document WHERE id = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }   
   
}