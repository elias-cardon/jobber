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
    }

    private function validateFirstName($fn) {
        if (strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constant::$firstNameCharacters);
        }
    }

    public function getErrorMessage($error){
        if (in_array($error, $this->errorArray)) {
            return '<span class="errorMessage">'.$error.'</span>';
        }
    }
}
