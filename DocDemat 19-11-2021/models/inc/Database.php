<?php
//La classe database qui stock la connexion à la base de donnée
class Database { 
    protected $db = NULL; 
    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=CAF_DocDemat;charset=utf8;', 'root', '');
        } catch (PDOException $ex) {
            die('Une erreur au niveau de la base de donnée s\'est produite !' . $ex->getMessage());
        }
    }
}