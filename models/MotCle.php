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
     * fonction qui insert un mot clé dans la base de données
     * @return boolean
     */
    public function insertMotCle()
    {
        $query = 'INSERT INTO `MotCle` (`nomMotCle`)  VALUES(:nom)';
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


}