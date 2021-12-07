<?php
 include_once('inc/Database.php');
class Motcle extends Database  
{
   private $id = null;
   private $nom;
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
    /**
     * affiche la liste des mot cle
     * @return un objet
     */
    public function listIMotCle(){
        $query = 'SELECT `id`, `nomMotCle` FROM `MotCle`';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * Ici la methode permet de verifier si le nom du mot clé existe déjà 
     * @return type objet
     */
    public function isExists() { 
        $query = 'SELECT COUNT(id) AS NomExists FROM MotCle WHERE nomMotCle = :nom ';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        $pdoStatment->execute();
        // Ici on fetch l'objet parce qu'on va sortir des valeur qu'on a déjà dans la base de donnée 
        return $pdoStatment->fetch(PDO::FETCH_OBJ); 
    } 
    /**
     * fonction qui insert un mot clé dans la base de données
     * @return boolean
     */
    public function insertMotCle()
    {
        $query = 'INSERT INTO `MotCle` (`nomMotCle`) VALUES(:nom)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        return $pdoStatment->execute();
    }
    /**
     * fonction qui delete les id et le nom du motclé dans la base de données
     * @return boolean
     */
    public function keyWordDeleted()
    {
        $query = 'DELETE FROM `MotCle` WHERE id = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
    /**
     * fonction qui sort les cadres attacher à un mot clé par son nom
     * @return objet
     */
    public function takeCadreOnMotcle()
    {
        $query = 'SELECT CadresDeTravail.id, CadresDeTravail.nom, IconeDesCadresDeTravail.image  FROM MotCle
        INNER JOIN cadre_MotCle ON MotCle.id = cadre_MotCle.id_MotCle
        INNER JOIN CadresDeTravail ON cadre_MotCle.id_CadresDeTravail = CadresDeTravail.id
        INNER JOIN IconeDesCadresDeTravail ON CadresDeTravail.id = IconeDesCadresDeTravail.id
        WHERE nomMotCle = :nom';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ); 
    }

}