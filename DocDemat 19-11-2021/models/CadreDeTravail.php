<?php
include_once('inc/Database.php');
class CadreDeTravail extends Database{
    private $id;
    private $nom;
    private $description;
    private $diaporama;
    private $idIcone;

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
    public function getIdIconeDesCadresDeTravail($idIcone){
        return $this->idIcone;
    }

    public function setIdIconeDesCadresDeTravail($idIcone){
        return $this->idIcone = $idIcone;
    }

 /**
     * Fonction qui fait la liste de cadre de travail 
     * @return objet
     */
   
   public function listCadre()
   {
        $sql = 'SELECT  `id`,`nom`, `description`,`diaporama`, `id_IconeDesCadresDeTravail` FROM `CadresDeTravail` ORDER BY CadresDeTravail.nom ASC';
        $pdoStatment = $this->db->prepare($sql);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
   }
   /**
    * Fonction qui insert un cadre de travail avec les
    * @return un boolean
    */
    public function inserCadre()
     {
            $sql = 'INSERT INTO `CadresDeTravail` (`nom`,`description`, `diaporama`) VALUES(:nom, :descri, :diaporama)';
            // $sql = 'INSERT INTO `CadresDeTravail` (`nom`,`description`, `diaporama`, `id_IconeDesCadresDeTravail`) VALUES(:nom, :descri, :diaporama, :idIcone)'; 
            $pdoStatment = $this->db->prepare($sql); 
            $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
            $pdoStatment->bindValue(':descri', $this->getDescription(), PDO::PARAM_STR);
            $pdoStatment->bindValue(':diaporama', $this->getDiaporama(), PDO::PARAM_INT); 
           return $pdoStatment->execute();
   }
   /**
    * Fonction qui fait la liste de cadre de travail avec une image icone
    * @return un objet
    */
   public function listCadreAvecIcone()
   {
        $sql = 'SELECT CadresDeTravail.id, CadresDeTravail.nom, IconeDesCadresDeTravail.image 
        FROM CadresDeTravail 
        INNER JOIN IconeDesCadresDeTravail 
        ON CadresDeTravail.id_IconeDesCadresDeTravail = IconeDesCadresDeTravail.id 
        ORDER BY CadresDeTravail.nom ASC';
        $pdoStatment = $this->db->prepare($sql);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
   }
   /**
    * Fonction qui fait la mis à jour d'un cadre de travail
    * @return un boolean
    */
//    public function miseAjourDesDonnees()
//    {
//         $sql='UPDATE CadresDeTravail 
//               SET nom=:nom, description=:descri, diaporama =:diaporama
//               WHERE id = :id';
//         $pdoStatment = $this->db->prepare($sql); 
//         $pdoStatment->bindValue(':nom', $this->getNom(), PDO::PARAM_STR);
//         $pdoStatment->bindValue(':descri', $this->getDescription(), PDO::PARAM_STR);
//         $pdoStatment->bindValue(':diaporama', $this->getDiaporama(), PDO::PARAM_INT);
//         $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
//         $pdoStatment->execute();
//         return true;
//     } 
// public function miseAjourDesDonneesDesc()
//     {
//         $sql='UPDATE CadresDeTravail 
//         SET  description =:descri 
//         WHERE id = :id';
//          $pdoStatment = $this->db->prepare($sql); 
//          $pdoStatment->bindValue(':descri', $this->getDescription(), PDO::PARAM_STR);
//          $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
//          $pdoStatment->execute();
//          return true;
//     }

    /**
    * Fonction qui insert un cadre de travail avec les
    * @return un boolean
    */
    public function inserNomCadre($name, $donnees)
     {   
            $sql = 'INSERT INTO CadresDeTravail ('.$name.') VALUES(:nom)'; 
            $pdoStatment = $this->db->prepare($sql); 
            $pdoStatment->bindValue(':nom', $donnees, PDO::PARAM_STR); 
            return $pdoStatment->execute();
   }
   /**
    * Fonction qui insert un cadre de travail avec les
    * @return un boolean
    */
    // public function inserDescCadre($donnees)
    // {
    //      $sql='UPDATE CadresDeTravail 
    //     SET description = :descri WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
    //     FROM CadresDeTravail) AS tempo)';
    //     $pdoStatment = $this->db->prepare($sql); 
       // // if($name === 'diaporama'){
        ////     $pdoStatment->bindValue(':descri', $donnees, PDO::PARAM_INT); 
        //// }else{
    //         $pdoStatment->bindValue(':descri', $donnees, PDO::PARAM_STR);
    //     // }
    //     $pdoStatment->execute();
    // }
            /*******insertion de description******/
    public function inserDescCadre($donnees,$nom)
    {
        $sql='UPDATE CadresDeTravail 
        SET description = :descri WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
        FROM CadresDeTravail WHERE nom = :nom ORDER BY id DESC) AS tempo)';
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':nom', $nom, PDO::PARAM_STR);
        $pdoStatment->bindValue(':descri', $donnees, PDO::PARAM_STR);
        $pdoStatment->execute();
    }

    //    insertion diaporama
    // public function inserDiapoCadre($donneesDiapos){
    //     $sql='UPDATE CadresDeTravail 
    //     SET diaporama = :diaporama 
    //     WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
    //     FROM CadresDeTravail) AS tempo)'; 
    //     $pdoStatment = $this->db->prepare($sql); 
    //     $pdoStatment->bindValue(':diaporama', $donneesDiapos, PDO::PARAM_INT); 
    //     return $pdoStatment->execute();
    // }
                /****insertion de diaporama*******/
    public function inserDiapoCadre($donneesDiapos,$nom){
        $sql='UPDATE CadresDeTravail 
        SET diaporama = :diaporama 
        WHERE id = (SELECT maxid FROM (SELECT MAX(id) AS maxid
        FROM CadresDeTravail  WHERE nom = :nom ORDER BY id DESC) AS tempo)'; 
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':nom', $nom, PDO::PARAM_STR);
        $pdoStatment->bindValue(':diaporama', $donneesDiapos, PDO::PARAM_INT); 
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
           /**
     * affiche  nomMotCle attacher a l'id du cadre de travail 
     * @return un objet
     */
    public function attachNameIdMotCle(){
        $query = 'SELECT id,nomMotCle FROM MotCle
        WHERE id IN  (SELECT id_MotCle FROM cadre_MotCle
        WHERE id_CadresDeTravail = :id)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }
           /**
     * liste de document attacher sur un cadre de travail 
     * @return un objet
     */
    public function listeDesDocumentsAttacher(){
        $query = 'SELECT  Document.id, Document.nom, cadre_Document.dureeAffichage, DATE_FORMAT(cadre_Document.dateDeFinValidite,\'%d/%m/%Y\') AS dateFin, DATE_FORMAT(cadre_Document.dateDebutDeValidite, \'%d/%m/%Y\') AS dateDebut, cadre_Document.raffraichissement, cadre_Document.ordreDePriorite
        FROM cadre_Document
        LEFT JOIN Document 
        ON cadre_Document.id_document = Document.id
        WHERE cadre_Document.id_CadresDeTravail = :id GROUP BY nom ORDER BY ordreDePriorite';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);     
    }
          /**
     * liste des icones attacher sur un cadre de travail 
     * @return un objet
     */
    // fonction pour mettre a jour la description
    public function miseAjourDesDonneesDesc($id)
    {
        $sql='UPDATE CadresDeTravail 
            SET  description =:descri 
            WHERE id = :id';
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':descri', $this->getDescription(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ret = $pdoStatment->execute();
        return $ret;
    }
    // miseAjour du diaporama
    public function miseAjourDesDonneesDiapo($id)
    {
        $sql='UPDATE CadresDeTravail 
            SET  diaporama =:diaporama
            WHERE id = :id';
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':diaporama', $this->getDiaporama(), PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ret = $pdoStatment->execute();
        return $ret;
    }

    /**
     * Une fonction qui modifi ou attache une nouvelle icone dans ce cadre
     * @return un
     */
    public function miseAjourIcones($idIcone){
        $sql='UPDATE CadresDeTravail
            SET  id_IconeDesCadresDeTravail =:idIcone
            WHERE id = :id';
         $pdoStatment = $this->db->prepare($sql); 
          $pdoStatment->bindValue(':idIcone', $idIcone,PDO::PARAM_INT);
         $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
         $ret = $pdoStatment->execute();
         return $ret;
    }

    /**
     * une fonction
     * @return object 
     */
    public function afficherDocumentAttacherCadre(){
        $sql = 'SELECT CadresDeTravail.diaporama, cadre_Document.id_document, cadre_Document.raffraichissement, cadre_Document.ordreDePriorite,
        cadre_Document.dateDebutDeValidite, cadre_Document.dateDeFinValidite, Document.nom, Document.chemin, types FROM Document
               INNER JOIN cadre_Document ON Document.id = cadre_Document.id_document
               INNER JOIN CadresDeTravail ON cadre_Document.id_CadresDeTravail = CadresDeTravail.id
               WHERE cadre_Document.id_CadresDeTravail = :id
               ORDER BY cadre_Document.ordreDePriorite ASC';
        $pdoStatment = $this->db->prepare($sql); 
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }
     /**
     * liste des icones attacher sur un cadre de travail 
     * @return un objet
     */
    public function iconAttacheCadre(){
        $query = 'SELECT IconeDesCadresDeTravail.id, IconeDesCadresDeTravail.nom, IconeDesCadresDeTravail.image 
                  FROM IconeDesCadresDeTravail
                  INNER JOIN CadresDeTravail
                  ON IconeDesCadresDeTravail.id = CadresDeTravail.id_IconeDesCadresDeTravail
                  WHERE CadresDeTravail.id =  (SELECT id FROM CadresDeTravail
                  WHERE id = :id)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);     
    }
    

// fonction qui met en jourleCadre de travail

        public function miseAjourCadrePourIcones($id)
        // UPDATE CadresDeTravail SET  id_IconeDesCadresDeTravail = NULL
        // WHERE id_IconeDesCadresDeTravail = 45;
        {
            var_dump($id);
            $query ='UPDATE CadresDeTravail SET  id_IconeDesCadresDeTravail = 1
            WHERE id_IconeDesCadresDeTravail = :idIcone';
            $pdoStatment = $this->db->prepare($query);
            $pdoStatment->bindValue(':idIcone', $id, PDO::PARAM_INT);
            return $pdoStatment->execute();
        }

    // fonction qui supprime un cadre de travail complet

    public function supprimerDesDonneesCadre()
    {
        $query ='DELETE FROM CadresDeTravail
        WHERE id = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }

    //fonction qui supprime id de l'icone dans le cadre de travail

    public function disaffectIcone(){
        // 'UPDATE IconeDesCadresDeTravail SET  id = NULL
        // WHERE id = :idIcone'   
        var_dump($this->getId());
        $query = 'UPDATE CadresDeTravail SET id_IconeDesCadresDeTravail = NULL   WHERE id = :id';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        return $pdoStatment->execute();
    }

    //afficher le nom des cadres attacher a un document avant suppression 
    public function recoverNameCadreAndBindId($recoverDoc){
        $query = ' SELECT nom FROM CadresDeTravail
        WHERE  id IN (SELECT id_CadresDeTravail FROM cadre_Document
        WHERE id_document = :id)';
        $pdoStatment = $this->db->prepare($query);
        $pdoStatment->bindValue(':id', $recoverDoc, PDO::PARAM_INT);
        $pdoStatment->execute();
        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);

      
        
    }
}