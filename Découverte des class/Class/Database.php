<?php
//Création de notre class Database, par convention, le nom du fichier porte le nom de la class
class Database
{
    //Création des variables en visibilité privé, on ne peut pas les appelés via "l'extérieur"
    private $login;
    private $password;
    private $host;
    private $db_name;
    private $pdo;

    //La fonction __construct permet d'exécuter le code dedans un l'initialisation de la class, la fonction doit être en pubic
    public function __construct($login = "root", $password = "", $host = "localhost", $db_name = "example")
    {
        //On utilises $this-> pour cibler la variable dite courante, celle définie plus haut,
        //vous remarquerez que l'on ne mets pas de $ avant le nom mais avant this
        $this->login = $login;
        $this->password = $password;
        $this->host = $host;
        $this->db_name = $db_name;
        //Ici on attribut $pdo à ce que va nous retourné la fonction
        $this->pdo = $this->setPDO();
    }

    //Création d'une fonction en privé setPDO
    private function setPDO()
    {
        try {
            $pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name .';charset=utf8', $this->login, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
        $this->pdo = $pdo;
        return $pdo;
    }

    //Création d'une fonction en privé, le = '' après $type permet de dire que si la variable type n'est pas donné lors de l'appel 
    private function request($request, $values, $type)
    {
        $request = $this->pdo->prepare($request);
        $request->execute($values);
        if ($type === 'fetchAll') {
            return $request->fetchAll(PDO::FETCH_OBJ);
        } elseif ($type === 'fetch') {
            return $request->fetch();
        } else {
            return $request;
        }
    }

    //Création d'une fonction en privé, le = '' après $type permet de dire que si la variable type n'est pas donné lors de l'appel lui attribuer ce qu'il y a entre les guillemets
    public function getRequest($request, $values, $type = '')
    {
        return $this->request($request, $values, $type);
    }
}

/*
 * Code écrit pas https://github.com/QuentinBubu/
 * Pour https://made.alwaysdata.net
 * Voir vos droits https://github.com/QuentinBubu/made/tree/master/D%C3%A9couverte%20des%20class
*/