<?php

session_start();

require_once 'Class/User.php';

//On récupère le type d'action préalablement définis via get: action="traitement.php?type=connexion"
if ($_GET['type'] === 'connexion') {
    if (isset($_POST['username'],
        $_POST['password'])
        && !empty($_POST['username'])
        && !empty($_POST['password'])
    ) {
        $user = new User; //Création d'une class user pour $user, $user à maintenant le type Object
        $return = $user->getConnexion($_POST['username'], $_POST['password']); //On appelle à la fonction getConnexion de la class User
        if ($return) {
            $_SESSION['id'] = $user->getId();//Appel à la fonction getId de la class User
            header('Location: /home.html');
            exit;
        } else {
            $_SESSION['error'] = $return;
            header('Location: /login.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Veuillez saisir tout les champs!';
        header('Location: /login.php');
        exit;
    }
} elseif ($_GET['type'] === 'inscription') {
    if (!isset($_POST['cgus'])) {
        $_SESSION['error'] = 'Veuillez accepter les conditions générals d\'utilisation';
        header('Location: /login.php');
        exit;
    }
    if (!isset(
        $_POST['username'],
        $_POST['password'],
        $_POST['passwordConfirm'],
        $_POST['email']
        )
        || empty($_POST['username'])
        || empty($_POST['password'])
        || empty($_POST['passwordConfirm'])
        || empty($_POST['email'])
    ) {
        $_SESSION['error'] = 'Saisissez tout les champs';
        header('Location: /login.php');
        exit;
    }
    $user = new User; //Création d'une class user pour $user, $user à maintenant le type Object
    $return = $user->getNewAccount(
        $_POST['username'],
        $_POST['password'],
        $_POST['passwordConfirm'],
        $_POST['email'],
    );

    if ($return) {
        header('Location: /hello.php');
        exit;
    } else {
        $_SESSION['error'] = $return;
        header('Location: /login.php');
        exit;
    }
}

/*
 * Code écrit pas https://github.com/QuentinBubu/
 * Pour https://made.alwaysdata.net
 * Voir vos droits https://github.com/QuentinBubu/made/tree/master/stats
*/
