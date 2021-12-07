<?php
include_once('inc/Database.php');
class CadreDeTravail extends Database{
private $id;
  private $nom;
  private $description;
  private $qrcode;
  private $diaporama;
//   private $idIcone;

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
    return $this->nom = $nom;
    }
    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        return $this->description = $description;
    }
    public function getDiaporama(){
        return $this->diaporama;
    }

    public function setDiaporama($diaporama){
        return $this->diaporama = $diaporama;
    }

 /**
     * Fonction qui fait la liste de cadre de travail 
     * @return objet
     */
   
   public function listCadre()
   {
        $sql = 'SELECT  `id`,`nom`, `description` FROM `CadresDeTravail` ORDER BY CadresDeTravail.nom ASC';
        $pdoStatment = $this->db->prepare($sql);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
   }
   /**
    * Fonction qui insert un cadre de travail avec les
    * @return un boolean
    */
    public function inserNomCadre($name, $donnees)
     {
        // $document = new Documents();
        // $motCles = new Motcle();
        // $icone = new IconeDesCadres();
        // $sql = 'INSERT INTO `CadresDeTravail` (`nom`,`description`, `diaporama`) VALUES(:nom, :descri, :diaporama)';
        // // $sql = 'INSERT INTO `CadresDeTravail` (`nom`,`description`, `diaporama`, `id_IconeDesCadresDeTravail`) VALUES(:nom, :descri, :diaporama, :idIcone)'; 
        // $pdoStatment = $this->db->prepare($sql); 
        // $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        // $pdoStatment->bindValue(':descri', $this->getDescription(), PDO::PARAM_STR);
        // $pdoStatment->bindValue(':diaporama', $this->getDiaporama(), PDO::PARAM_INT); 
        // return $pdoStatment->execute();
        
            $sql = 'INSERT INTO CadresDeTravail ('.$name.') VALUES(:nom)'; 
            $pdoStatment = $this->db->prepare($sql); 
            $pdoStatment->bindValue(':nom', $donnees, PDO::PARAM_STR); 
            return $pdoStatment->execute();
   }
   /**
    * Fonction qui insert un cadre de travail avec les
    * @return un boolean
    */
    public function inserDescCadre($name, $donnees)
     {
        $sql='UPDATE CadresDeTravail SET '.$name.' = :descri WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
        FROM CadresDeTravail) AS tempo)';
        //UPDATE CadresDeTravail SET description = 'change' WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
        // FROM CadresDeTravail) AS tempo);
        $pdoStatment = $this->db->prepare($sql); 
        if($name === 'diaporama'){
            $pdoStatment->bindValue(':descri', $donnees, PDO::PARAM_INT); 
        }else{
            $pdoStatment->bindValue(':descri', $donnees, PDO::PARAM_STR);
        }
        $pdoStatment->execute();
   }
   /**
     * Ici la methode permet de verifier si la variable existe déjà 
     * @return type objet
     */
    public function isExists($name, $donnees) { 
        $query = 'SELECT COUNT(id) AS NomExists FROM CadresDeTravail WHERE '.$name.' = :nom ';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':nom', $donnees, PDO::PARAM_STR);
        $pdoStatment->execute();
        // Ici on fetch l'objet parce qu'on va sortir des valeur qu'on a déjà dans la base de donnée 
        return $pdoStatment->fetch(PDO::FETCH_OBJ); 
    }
   /**
    * Fonction qui fait la liste de cadre de travail avec une image icone
    * @return un objet
    */
   public function listCadreAvecIcone()
   {
        $sql = 'SELECT CadresDeTravail.id, CadresDeTravail.nom, IconeDesCadresDeTravail.image FROM CadresDeTravail INNER JOIN IconeDesCadresDeTravail ON CadresDeTravail.id_IconeDesCadresDeTravail = IconeDesCadresDeTravail.id ORDER BY CadresDeTravail.nom ASC';
        $pdoStatment = $this->db->prepare($sql);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
   }
   /**
    * Fonction qui fait la mis à jour d'un cadre de travail
    * @return un boolean
    */
   public function miseAjourDesDonnees()
   {
        $sql='UPDATE CadresDeTravail 
              SET nom=:nom, description=:descri, diaporama =:diaporama
              WHERE id = :id';
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':descri', $this->getDescription(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':diaporama', $this->getDiaporama(), PDO::PARAM_INT);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $pdoStatment->execute();
        return true;
    } 
    /**
     * Ici la methode permet d'avoir la valeur de la colonne icone dans la dernière ligne de la table CadresDeTravail
     * @return type objet
     */
    public function ValDernièreColonne() { 
        $query = 'SELECT id_IconeDesCadresDeTravail
                  FROM CadresDeTravail
                  WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
                  FROM CadresDeTravail) AS tempo)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->execute();
        // Ici on fetch l'objet parce qu'on va sortir des valeur qu'on a déjà dans la base de donnée 
        return $pdoStatment->fetch(PDO::FETCH_OBJ); 
    }  
/**
     * affiche la liste des ids icones
     * @return un objet
     */
    public function reattachIcone($toRecoverId){
        $query = ' UPDATE CadresDeTravail SET id_IconeDesCadresDeTravail = :idIcone
                    WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
                    FROM CadresDeTravail) AS tempo)';       
                    var_dump($toRecoverId);
        
                    $pdoStatment = $this->db->prepare($query);
                    $pdoStatment->bindValue(':idIcone', $toRecoverId,PDO::PARAM_INT);
                    return $pdoStatment->execute();
    }
}