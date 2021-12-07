<?php
 include_once('inc/Database.php');
 include_once('MotCle.php');
class Cadre_MotCle extends Database  
{
   private $id_MotCle = null;
   private $id_CadresDeTravail = null;

    public function getIdMotCle(){
        return $this->id_MotCle;
    }
    public function setMotCle($id_MotCle){
        $this->id_MotCle = $id_MotCle;
    }
    public function getIdCadresDeTravail(){
        return $this->id_CadresDeTravail;
    }
    public function setIdCadresDeTravail($id_CadresDeTravail){
        $this->id_CadresDeTravail = $id_CadresDeTravail;
    } 
    // public function nombreCadreAttacher($value){
    //     $query = 'SELECT COUNT(id_CadresDeTravail) AS idCadreAttacher 
    //     FROM cadre_MotCle WHERE id_CadresDeTravail = '.$value.' )';
    //     $pdoStatment = $this->db->prepare($query);
    //     $pdoStatment->execute();
    //     return $pdoStatment->fetch(PDO::FETCH_OBJ);
    // }
    /**
     * affiche la liste des ids
     * @return un objet
     */
    public function insertId($recupId, $recupIdCadre){
        $query = 'INSERT INTO cadre_MotCle (id_MotCle, id_CadresDeTravail) 
                  VALUES ((SELECT id FROM MotCle WHERE id = :idMotcle), 
                 (SELECT id FROM CadresDeTravail WHERE id = :cadre))';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':idMotcle', $recupId, PDO::PARAM_INT);
        $pdoStatment->bindValue(':cadre', $recupIdCadre, PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * fonction qui supprimer les id dans la base de données
     * @return boolean
     */
    public function deleteIdCadre_Motcle()
    {
        $query = 'DELETE FROM `Cadre_MotCle` WHERE id_MotCle = :id_MotCle AND id_CadresDeTravail = :id_CadresDeTravail' ;
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id_MotCle', $this->getIdMotCle(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id_CadresDeTravail', $this->getIdCadresDeTravail(), PDO::PARAM_STR);
        return $pdoStatment->execute();
    }
    /**
     *fonction qui recupere le nom du cadre attacher au id du motCle
     * @return un objet
     */
    public function recoverNameCadreAndKeyWordIdI($recoverMotCle){ 
        $sql = 'SELECT nom FROM CadresDeTravail
        WHERE  id IN (SELECT id_CadresDeTravail FROM cadre_MotCle
        WHERE id_MotCle = :id)';
        $pdoStatment = $this->db->prepare($sql);
        $pdoStatment->bindValue(':id',$recoverMotCle, PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ); 
    }
     /**
      * Fonction qui compte le nombre des mot clés rattacher à un cadre (par l'id du cadre)
      * @return un objet
      */
      public function nombreMotcleAttacherAuCadre($theIdMotcle){
        $query = 'SELECT COUNT(id_CadresDeTravail) AS idCadreAttacherAuMotcle 
                 FROM cadre_MotCle WHERE id_CadresDeTravail = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $theIdMotcle, PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }
    /**
     * Met à jour un cadre, attache des mot clés sur un cadre créer (avec l'id de cadre)
     * @return un boolean
     */
    public function attacheDesMotcles($theId, $theIdCatre){
        // nom,chemin,dureeAffichage,dateDeFinDeValidite,dateDeDebutDeValidite,
        $query = 'INSERT INTO cadre_MotCle (id_MotCle, id_CadresDeTravail) 
        VALUES (:idMotcle,:idCadre)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':idMotcle', $theId, PDO::PARAM_INT);
        $pdoStatment->bindValue(':idCadre', $theIdCatre, PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
                 /**
     * fonction qui delete les motclé au check dans la base de données
     * @return boolean
     */
    public function keyWordDeletedCheckIn($idKeyWord,$idCadre)
    {
        
        $query = 'DELETE FROM `cadre_MotCle` WHERE id_MotCle = :id_MotCle AND id_CadresDeTravail = :id_CadresDeTravail' ;
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id_MotCle', $idKeyWord, PDO::PARAM_INT);
        $pdoStatment->bindValue(':id_CadresDeTravail',$idCadre, PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * fonction qui delete les mots cle du tableau sur la corbeille global 
     * @return boolean
     */
    public function deletedAllKeyWord($idMotCle,$idCadre)
    {
        $query = 'DELETE FROM `cadre_MotCle` WHERE id_Motcle IN ('.$idMotCle.') AND id_CadresDeTravail = :id_CadresDeTravail';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id_CadresDeTravail',$idCadre, PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
        /**
     * fonction qui delete les mots cle de tout les cadres de travail 
     * @return boolean
     */
    public function keyWordDeletedAll()
    {
        $query = 'DELETE FROM `cadre_MotCle` WHERE id_Motcle = :id_Motcle ';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id_Motcle',$this->getIdMotCle(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }
  
}