<?php

if (isset($_GET['idTheme']) || isset($_SESSION['idTheme'])) {
    if (isset($_GET['idTheme'])) {
        $_SESSION['idTheme'] = $_GET['idTheme'];
    }
} else {
    header('Location: index.php');
}

if (isset($_POST) || !empty($_POST)) {
    if (isset($_POST["modif"])) {
        if (!empty($_POST['idMot']) && !empty($_POST['contenuMot']) && !empty($_POST['nbPointsMot']) && !empty($_POST['dureeMot'])) {
            $pdo->modifierMots($_POST['idMot'], $_POST['contenuMot'], $_POST['nbPointsMot'], $_POST['dureeMot']);
        } else {
            ajouterErreur("Veuillez renseigner tout les champs");
            include ('vues\v_erreurs.php');
        }
    }
    if (isset($_POST["ajouter"])) {
        if (!empty($_POST['mot']) && !empty($_POST['point']) && !empty($_POST['duree'])) {
            $pdo->ajouterMots($_POST['mot'], $_POST['point'], $_SESSION['idTheme'], $_POST['duree']);
        } else {
            ajouterErreur('Veuillez mettre un nom, un nombre de point et une durée non nulle.');
            include ('vues\v_erreurs.php');
        }
    }
}
if (isset($_GET["sup"])) {
    $pdo->supprimerMots($_GET['sup']);
    header('location:index.php?uc=gestionMots');
}

$lesMots = $pdo->afficherMots($_SESSION['idTheme']);

include("vues/v_gestionMots.php");
