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
    private static $bdd = 'dbname=bomargo';
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
    public function getVisiteur($login, $mdp) {
        $res = PdoGsb::$monPdo->prepare
                ("SELECT idGSB, nom, prenom FROM visiteur "
                . "WHERE login = :login AND mdp = :mdp ");
        $res->bindValue('login', $login);
        $res->bindValue('mdp', $mdp);
        $res->execute();
        $Ligne = $res->fetch();
        return $Ligne;
    }

    /**
     * Fonction qui permet d'afficher thème
     *
     * @return La liste des thèmes
     */
    public function afficherThemes() {
        $res = PdoGsb::$monPdo->prepare
                ("SELECT idTheme, nomTheme, dureeTheme, COUNT(idMot) AS nbMots "
                . "FROM THEMES T "
                . "LEFT JOIN MOTS M "
                . "ON T.idTheme = M.idThemeMot "
                . "GROUP BY idTheme, nomTheme, dureeTheme "
        );
        $res->execute();
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Fonction qui permet modifier un thème
     *
     * @param $idTheme 
     * @param $nomTheme
     *
     */
    public function modifierThemesNom($idTheme, $nomTheme) {
        $res = PdoGsb::$monPdo->prepare
                ("UPDATE THEMES "
                . "SET nomTheme = :nomTheme "
                . "WHERE idTheme = :idTheme ");
        $res->bindValue('idTheme', $idTheme);
        $res->bindValue('nomTheme', $nomTheme);
        $res->execute();
    }

    /**
     * Fonction qui permet modifier la durée du thème
     *
     * @param $idTheme 
     * @param $dureeTheme
     *
     */
    public function modifierThemesDuree($idTheme, $dureeTheme) {
        $res = PdoGsb::$monPdo->prepare
                ("UPDATE THEMES "
                . "SET dureeTheme = :dureeTheme "
                . "WHERE idTheme = :idTheme ");
        $res->bindValue('idTheme', $idTheme);
        $res->bindValue('dureeTheme', $dureeTheme);
        $res->execute();
    }

    /**
     * Fonction qui permet d'ajouter un thème
     *
     * @param $nomTheme 
     * @param $dureeTheme
     *
     */
    public function ajouterThemes($nomTheme, $dureeTheme) {
        $res = PdoGsb::$monPdo->prepare
                ("INSERT INTO THEMES "
                . "VALUES('',:nomTheme,:dureeTheme) ");
        $res->bindValue('nomTheme', $nomTheme);
        $res->bindValue('dureeTheme', $dureeTheme);
        $res->execute();
    }

    /**
     * Fonction qui permet de supprimer un thème
     *
     * @param $idTheme 
     *
     */
    public function supprimerThemes($idTheme) {
        $res = PdoGsb::$monPdo->prepare
                ("DELETE FROM MOTS WHERE idThemeMot = :idThemeMot ");
        $res->bindValue('idThemeMot', $idTheme);
        $res->execute();
        $res1 = PdoGsb::$monPdo->prepare
                ("DELETE FROM THEMES WHERE idTheme = :idTheme ");
        $res1->bindValue('idTheme', $idTheme);
        $res1->execute();
    }

    /**
     * Fonction qui permet d'afficher les mots
     *
     * @param $idTheme 
     *
     * @return La liste des mots
     */
    public function afficherMots($idTheme) {
        $res = PdoGsb::$monPdo->prepare("SELECT * FROM MOTS WHERE idThemeMot = :idTheme");
        $res->bindValue('idTheme', $idTheme);
        $res->execute();
        $ligne = $res->fetchAll();
        return $ligne;
    }

    /**
     * Fonction qui permet de modifier un mots
     *
     * @param $idTheme 
     *
     */
    public function modifierMots($idMot, $contenuMot, $nbPointsMot, $dureeMot) {
        $res = PdoGsb::$monPdo->prepare
                ("UPDATE MOTS "
                . "SET contenuMot = :contenuMot, "
                . "nbPointsMot = :nbPointsMot, "
                . "dureeMot = :dureeMot "
                . "WHERE idMot = :idMot ");
        $res->bindValue('idMot', $idMot);
        $res->bindValue('contenuMot', $contenuMot);
        $res->bindValue('nbPointsMot', $nbPointsMot);
        $res->bindValue('dureeMot', $dureeMot);
        $res->execute();
    }

    /**
     * Fonction qui permet d'ajouter un mot
     *
     * @param $contenuMot 
     * @param $nbPointsMot 
     * @param $idThemeMot 
     * @param $dureeMot 
     *
     */
    public function ajouterMots($contenuMot, $nbPointsMot, $idThemeMot, $dureeMot) {
        $res = PdoGsb::$monPdo->prepare
                ("INSERT INTO MOTS "
                . "VALUES('',:contenuMot,:nbPointsMot,:idThemeMot,:dureeMot) ");
        $res->bindValue('contenuMot', $contenuMot);
        $res->bindValue('nbPointsMot', $nbPointsMot);
        $res->bindValue('idThemeMot', $idThemeMot);
        $res->bindValue('dureeMot', $dureeMot);
        $res->execute();
    }

    /**
     * Fonction qui permet de supprimer un mot
     *
     * @param $idMot 
     *
     */
    public function supprimerMots($idMot) {
        $res = PdoGsb::$monPdo->prepare
                ("DELETE FROM MOTS WHERE idMot = :idMot ");
        $res->bindValue('idMot', $idMot);
        $res->execute();
    }

}
?>