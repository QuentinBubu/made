<?php

session_start();

require_once 'Database.php';

//Le extends va permettre de faire hériter la class Database à User, en quelque sorte, les class seront fusionnées
class User extends Database
{
    //Création de la variable globalAccountInformation en visibilité privé pour en savoir plus
    // https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/oriente-objet-encapsulation-public-protected-private/
    private $globalAccountInformation;

    //Définition de setNewAccount en visibilité privé
    private function setNewAccount($userName, $password, $passwordConfirm, $mail)
    {
        //$this->getRequest permet d'appeler la fonction dite courante getRequest
        $accountNumber = 
        $this->getRequest(
            'SELECT *
            FROM `users` 
            WHERE `userName` = :userName 
            OR `mail` = :mail',
            [
                'userName' => $userName,
                'mail' => $mail
            ],
            'fetchAll'
        );
        if (
            count($accountNumber) != 0
        ) {
            return 'Nom d\'utilisateur ou adresse mail déjà existante! ' .  var_dump($accountNumber);
        } elseif (
            $password !== $passwordConfirm
        ) {
            return 'Les mots de passe ne correspondent pas!';
        } elseif (
            strlen($password) < 10
            || strlen($password) > 30
        ) {
            return 'Saisissez un mot de passe entre 10 et 30 caractères!';
        } elseif (
            strlen($userName) < 5
            || strlen($userName) > 20
        ) {
            return 'Votre identifiant doit contenir entre 5 et 20 caractères!';
        } elseif (
            !filter_var($mail, FILTER_VALIDATE_EMAIL)
        ) {
            return 'Saisissez une adresse mail valide!';
        } else {
            date_default_timezone_set('Europe/Paris');
            $token = "M" . sha1(session_id() . microtime());
            if (
            $this->getRequest(
                'INSERT INTO `users`
                (
                    `userName`,
                    `password`,
                    `mail`,
                    `creationDate`,
                    `profilImage`,
                    `token`
                ) VALUES
                (
                    :userName,
                    :pswd,
                    :mail,
                    NOW(),
                    :profilImage,
                    :token
                )', 
                [
                    'userName' => $userName,
                    'pswd' => password_hash($password, PASSWORD_ARGON2ID),
                    'mail' => $mail,
                    'profilImage' => '/ressources/pictures/default/profil.svg',
                    'token' => $token
                ]
            ))
            {
                return true;
            } else {
                return 'Une erreur s\'est produite!';
            }
        }

    }

    //Définition de setConnexion en visibilité privé
    private function setConnexion($userName, $password)
    {
        $request = $this->getRequest(
           'SELECT *
           FROM `users`
           WHERE `userName` = :userName
           OR `mail` = :userName',
        [
            'userName' => $userName
        ],
        'fetch');

        if (!$request) {
            return 'Compte introuvable';
        } elseif (!password_verify($password, $request['password'])) {
            return 'Mot de passe incorrect';
        } elseif (substr($request['token'], 0, 1) !== 'V') {
            return 'Validez d\'abord votre compte!';
        } else {
            $this->globalAccountInformation = $request;
            $this->accountType = $request['accountType'];
            $_SESSION['id'] = $request['id'];
            return true;
        }
    }

    public function getNewAccount($userName, $password, $passwordConfirm, $mail)
    {
        return $this->setNewAccount($userName, $password, $passwordConfirm, $mail);
    }

    public function getConnexion($userName, $password)
    {
        return $this->setConnexion($userName, $password);
    }

    public function getToken()
    {
        return $this->globalAccountInformation['token'];
    }

    public function getId()
    {
        return $this->globalAccountInformation['id'];
    }

    public function getUseName()
    {
        return $this->globalAccountInformation['userName'];
    }

    public function getAccountType()
    {
        return $this->globalAccountInformation['accountType'];
    }
    /*
     * Vous remarquerez que ci-dessus une liste de fonction sont définis en visibilité public
     * Notamment par convention, on définis les fonctions faisant l'actions avec le nom commençant par set et mise en private
     * Et les fonctions les appelantes commencent par get, quand à elles, elles sont en public
     * Pour éviter d'accéder à toutes les données de $globalAccountInformation, on définis des fonctions qui vont retourner des données bien précises
    */
}