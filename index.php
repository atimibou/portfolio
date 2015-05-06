<?php
session_start();
require_once("includes/fct.inc.php");
require_once ("includes/class.pdogsb.inc.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
            include("controleurs/c_accueil.php");
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
include("vues/v_footer.php");
?>