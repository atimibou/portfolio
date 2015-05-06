<?php
session_start();
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php");
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
if ($estConnecte == false) {
    $_GET['uc'] = 'connexion';
} else {
    if (!isset($_GET['uc'])) {
        $_GET['uc'] = 'index';
    }
}
$uc = $_GET['uc'];
switch ($uc) {
    case 'index': {
            include("controleurs/c_gererThemes.php");
            break;
        }
    case 'gestionMots': {
            include("controleurs/c_gererMots.php");
            break;
        }
    case 'connexion': {
            include("controleurs/c_connexion.php");
            break;
        }
    case 'deconnexion': {
            deconnecter();
            header('location:index.php');
            break;
        }
}
include("vues/v_pied.php");
?>