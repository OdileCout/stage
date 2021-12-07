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
        $query ='DELETE  FROM IconeDesCadresDeTravail WHERE id = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }

    // fonction pour mettre a jour lesIcones si le cadre est supprimer 
     
    // public function miseAjourIconePourIcones()
    // // UPDATE IconeDesCadresDeTravail SET  id = NULL WHERE id= 92;
    // {
    //     $query ='UPDATE IconeDesCadresDeTravail SET  id = NULL
    //     WHERE id = :idIcone';
    //     $pdoStatment = $this->db->prepare($query);
    //     $pdoStatment->bindValue(':idIcone', $this->getId(), PDO::PARAM_INT);
    //     return $pdoStatment->execute();
    // }
        


}