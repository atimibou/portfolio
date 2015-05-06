<?php

/**
 * Classe d'accès aux données. 

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 * 
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */
class PdoGsb {

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=yport';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
        try {
            PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
            PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
        } catch (PDOException $Exception) {
            throw new MyDatabaseException($Exception->getMessage(), $Exception->getCode());
        }
    }

    public function _destruct() {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe

     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();

     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb() {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Cette fonction retourne les informations d'un user

     * @param $login 
     * @param $mdp
     * @return l'id, le login sous la forme d'un tableau associatif 
     */
    public function getMembre($login, $mdp) {
        $res = PdoGsb::$monPdo->prepare
                ("SELECT id, nom, prenom FROM membres "
                . "WHERE login = :login AND mdp = :mdp ");
        $res->bindValue('login', $login);
        $res->bindValue('mdp', $mdp);
        $res->execute();
        $Ligne = $res->fetch();
        return $Ligne;
    }

    /**
     * Fonction qui permet d'afficher les projets
     *
     * @return La liste des projets
     */
    public function afficherProjet() {
        $res = PdoGsb::$monPdo->prepare
                ("SELECT id, nomProjet, contexte, description"
                . "FROM Projet"
                );
        $res->execute();
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }
}

