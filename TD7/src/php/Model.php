<?php

require_once('Conf.php');

class Model {

    public static $pdo;

    public static function init_pdo() {
        $host   = Conf::getHostname();
        $dbname = Conf::getDatabase();
        $login  = Conf::getLogin();
        $pass   = Conf::getPassword();
        try {
            // connexion à la base de données
            // le dernier argument sert à ce que toutes les chaines de charactères
            // en entrée et sortie de MySql soit dans le codage UTF-8
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // on active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            die("Problème lors de la connexion à la base de données.");
        }
    }

    public static function emprunterLivre($idLivre,$idAdherent){
        try {
            // préparation de la requête
            $sql = "INSERT INTO `emprunt` (`idAdherent`, `idLivre`) VALUES (:idAdherent, :idLivre);";
            $req_prep = self::$pdo->prepare($sql);
            $values = array("idLivre" => $idLivre,
                            "idAdherent" => $idAdherent);
            $req_prep->execute($values);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }
    public static function rendreLivre($id){
        try {
            // préparation de la requête
            $sql = "DELETE FROM `emprunt` WHERE `emprunt`.`idLivre` = :idLivre ";
            $req_prep = self::$pdo->prepare($sql);
            $values = array("idLivre" => $id);
            $req_prep->execute($values);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }
    public static function createSomething($thing,$nom){
        if($thing == "adherent"){
            try {
            // préparation de la requête
            $sql = "INSERT INTO `adherent` (`idAdherent`, `nomAdherent`) VALUES (NULL, :nom_tag)";
            $req_prep = self::$pdo->prepare($sql);
            // passage de la valeur de name_tag
            $values = array("nom_tag" => $nom);
            // exécution de la requête préparée
            $req_prep->execute($values);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la creation.");
        }
        }
        elseif ($thing == "livre") {
            try {
            // préparation de la requête
            $sql = "INSERT INTO `livre` (`idLivre`, `titreLivre`) VALUES (NULL, :nom_tag)";
            $req_prep = self::$pdo->prepare($sql);
            // passage de la valeur de name_tag
            $values = array("nom_tag" => $nom);
            // exécution de la requête préparée
            $req_prep->execute($values);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la creation.");
        }
        }
        
    }
    public static function getAllLivreDispo(){
        try {
            // préparation de la requête
            $sql = "SELECT * FROM livre where idLivre not in (SELECT idLivre from emprunt)";
            $req_prep = self::$pdo->prepare($sql);
            $req_prep->execute();
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tabResults = $req_prep->fetchAll();
            // renvoi du tableau de résultats
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    public static function getAllLivrePris(){
        try {
            // préparation de la requête
            $sql = "SELECT * FROM livre where idLivre in (SELECT idLivre from emprunt)";
            $req_prep = self::$pdo->prepare($sql);
            $req_prep->execute();
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tabResults = $req_prep->fetchAll();
            // renvoi du tableau de résultats
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    public static function getLivresEmprunte($id){
        try {
            // préparation de la requête
            $sql = "SELECT l.titreLivre from livre l join emprunt e on l.idLivre = e.idLivre where e.idAdherent = :idAdherent";
            $req_prep = self::$pdo->prepare($sql);
            // passage de la valeur de name_tag
            $values = array("idAdherent" => $id);
            // exécution de la requête préparée
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tabResults = $req_prep->fetchAll();
            // renvoi du tableau de résultats
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }

    }
    public static function getEmprunteur($id){
        try {
            // préparation de la requête
            $sql = "SELECT a.nomAdherent,e.idLivre from adherent a join emprunt e on a.idAdherent = e.idAdherent where e.idLivre = :idLivre";
            $req_prep = self::$pdo->prepare($sql);
            // passage de la valeur de name_tag
            $values = array("idLivre" => $id);
            // exécution de la requête préparée
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tabResults = $req_prep->fetchAll();
            // renvoi du tableau de résultats
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }

    }
    

    public static function getAllAdherents() {
        try {
            // préparation de la requête
            $sql = "SELECT a.idAdherent,nomAdherent,count(e.idAdherent) FROM adherent a left join emprunt e on e.idAdherent = a.idAdherent group by a.idAdherent ";
            $req_prep = self::$pdo->prepare($sql);
            $req_prep->execute();
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tabResults = $req_prep->fetchAll();
            // renvoi du tableau de résultats
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

     public static function selectAdherent($id) {
        try {
            // préparation de la requête
            $sql = "SELECT * FROM adherent WHERE idAdherent = :id_tag ";
            $req_prep = self::$pdo->prepare($sql);
            // passage de la valeur de name_tag
            $values = array("id_tag" => $id);
            // exécution de la requête préparée
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tabResults = $req_prep->fetchAll();
            // renvoi du tableau de résultats
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }


}

// on initialise la connexion $pdo
Model::init_pdo();

?>
