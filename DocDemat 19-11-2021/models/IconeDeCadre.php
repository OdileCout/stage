<?php
include_once('inc/Database.php');
class IconeDesCadres extends Database{
    private $id = null;
    private $nom ;
    private $image ;

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
    public function getImage(){
        return $this->image;
    }
    public function setImage($image){
        $this->image = $image;
    } 
    /**
     * Une fonction qui retourne une liste des icones dans la base de données
     * @return objet
     */
    public function listIconeCadres(){
        $query = 'SELECT `id`, `nom`, `image` FROM `IconeDesCadresDeTravail`';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * Ici la methode permet de verifier si le nom de l'icone existe déjà 
     * @return type objet
     */
    public function isExists() { 
        $query = 'SELECT COUNT(id) AS NomExists FROM IconeDesCadresDeTravail WHERE nom = :nom ';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        $pdoStatment->execute();
        // Ici on fetch l'objet parce qu'on va sortir des valeur qu'on a déjà dans la base de donnée 
        return $pdoStatment->fetch(PDO::FETCH_OBJ); 
    } 
    /**
     * Une fonction qui insert un icon dans la base de données
     * @return boolean
     */
        public function insererIconeCadres(){
            $query = 'INSERT INTO `IconeDesCadresDeTravail` (`nom`, `image`)  VALUES(:nom, :img)';
            $pdoStatment = $this->db->prepare($query); 
            $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
            $pdoStatment->bindValue(':img', $this->getImage(), PDO::PARAM_STR); 
            return $pdoStatment->execute();
        }

        /**
         * fonction qui delete les id et le nom icones  dans la base de données
         * @return boolean
         */
        public function iconeDeleted()
    {  
        $query ='DELETE  FROM IconeDesCadresDeTravail WHERE (id = :id AND id !=1)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
    // public function iconeDeleted()
    // {
    //     $query ='DELETE  FROM IconeDesCadresDeTravail WHERE id = :id';
    //     $pdoStatment = $this->db->prepare($query);
    //     $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
    //     return $pdoStatment->execute();
    // }

}