<?php

class Account {
    // Instance PDO pour interagir avec la base de données
    private $pdo;
    private $errorArray=array();

    // Constructeur : initialise la connexion à la base de données
    public function __construct() {
        $this->pdo = Database::instance();  // Obtient l'instance unique de la classe Database (singleton)
    }

    // Méthode pour enregistrer un nouvel utilisateur
    // Paramètres : $fn (prénom), $ln (nom), $un (nom d'utilisateur),
    // $em (email), $pw (mot de passe), $pw2 (confirmation mot de passe)
    public function register($fn, $ln, $un, $em, $pw, $pw2) {
        // TODO : Implémenter la logique d'enregistrement (validation, insertion en base de données)
        $this->validateFirstName($fn);
        $this->validatelastName($ln);
    }

    private function validateFirstName($fn) {
        if (strlen($fn) < 2 || strlen($fn) > 25) {
            return array_push($this->errorArray, Constant::$firstNameCharacters);
        }
    }


    private function validateLastName($ln) {
        if (strlen($ln) < 2 || strlen($ln) > 25) {
            return array_push($this->errorArray, Constant::$lastNameCharacters);
        }
    }

    public function generateUsername($fn,$ln) {
        if (!empty($fn) && !empty($ln)) {
            if (!in_array(Constant::$firstNameCharacters, $this->errorArray) && !in_array(Constant::$lastNameCharacters, $this->errorArray)) {
                $username = strtolower($fn.''.$ln);
                if ($this->checkUsernameExist($username)) {
                    $screenRand=rand();
                    $userLink=$username.''.$screenRand;
                }else{
                    $userLink = $username;
                }
                return $userLink;
            }
        }
    }

    private function checkUsernameExist($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            return true;
        } else{
            return false;
        }
    }

    public function getErrorMessage($error){
        if (in_array($error, $this->errorArray)) {
            return '<span class="errorMessage">'.$error.'</span>';
        }
    }
}
