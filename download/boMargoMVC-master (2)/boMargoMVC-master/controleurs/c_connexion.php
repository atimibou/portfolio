<?php

if (!estConnecte()) {
    if (isset($_POST) && !empty($_POST)) {

        if (isset($_POST["connexion"]) && !empty($_POST['login']) && !empty($_POST['mdp'])) {
            $user = $pdo->getVisiteur($_POST['login'], $_POST['mdp']);
            if (empty($user)) {
                echo '<pre>';
                var_dump($user);
                die();
                ajouterErreur('Login ou mot de passe incorrect');
                include("vues/v_erreurs.php");
            } else {

                connecter($user['idGSB'], $user['nom'], $user['prenom']);
                header('Location:index.php');
            }
        } else {
            ajouterErreur('Login ou mot de passe incorrect');
            include("vues/v_erreurs.php");
        }
    }

    include("vues/v_connexion.php");
} 
else 
    {
        header('Location:index.php');
    }