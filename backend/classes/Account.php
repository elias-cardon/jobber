<?php

class Account {
    // Instance PDO pour interagir avec la base de données
    private $pdo;
    // Tableau pour stocker les messages d'erreur liés à la validation
    private $errorArray = array();

    // Constructeur : initialise la connexion à la base de données
    public function __construct() {
        $this->pdo = Database::instance();  // Obtient l'instance unique de la classe Database (singleton)
    }

    // Méthode pour enregistrer un nouvel utilisateur
    // Valide les champs obligatoires et prépare l'utilisateur pour l'insertion dans la base de données
    public function register($fn, $ln, $un, $em, $pw, $pw2) {
        // Validation du prénom
        $this->validateFirstName($fn);
        // Validation du nom
        $this->validateLastName($ln);
        // Validation de l'email
        $this->validateEmail($em);
        // TODO : Ajouter des validations pour le mot de passe et l'insertion en base de données
    }

    // Valide la longueur du prénom (entre 2 et 25 caractères)
    private function validateFirstName($fn) {
        // Vérifie si la longueur du prénom est hors des limites autorisées
        if ($this->length($fn, 2, 25)) {
            return array_push($this->errorArray, Constant::$firstNameCharacters);
        }
    }

    // Valide la longueur du nom (entre 2 et 25 caractères)
    private function validateLastName($ln) {
        // Vérifie si la longueur du nom est hors des limites autorisées
        if ($this->length($ln, 2, 25)) {
            return array_push($this->errorArray, Constant::$lastNameCharacters);
        }
    }

    // Valide l'email
    private function validateEmail($email) {
        // Prépare une requête pour vérifier si l'email existe déjà dans la base de données
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount(); // Compte le nombre de résultats
        if ($count > 0) {
            // Ajoute un message d'erreur si l'email est déjà utilisé
            return array_push($this->errorArray, Constant::$emailInUse);
        }
        // Vérifie si l'email est dans un format valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Ajoute un message d'erreur si le format de l'email est incorrect
            return array_push($this->errorArray, Constant::$emailInvalid);
        }
    }

    // Génère un nom d'utilisateur à partir du prénom et du nom
    // Ajoute un nombre aléatoire si le nom d'utilisateur existe déjà
    public function generateUsername($fn, $ln) {
        if (!empty($fn) && !empty($ln)) {
            // Vérifie si les champs prénom et nom sont valides
            if (!in_array(Constant::$firstNameCharacters, $this->errorArray) && !in_array(Constant::$lastNameCharacters, $this->errorArray)) {
                $username = strtolower($fn . $ln); // Concatène prénom et nom en minuscules
                // Vérifie si le nom d'utilisateur existe déjà
                if ($this->checkUsernameExist($username)) {
                    $screenRand = rand(); // Génère un nombre aléatoire
                    $userLink = $username . $screenRand; // Ajoute le nombre au nom d'utilisateur
                } else {
                    $userLink = $username;
                }
                return $userLink; // Retourne le nom d'utilisateur généré
            }
        }
    }

    // Vérifie si un nom d'utilisateur existe déjà dans la base de données
    private function checkUsernameExist($username) {
        // Prépare une requête pour vérifier si le nom d'utilisateur existe
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount(); // Compte le nombre de résultats
        if ($count > 0) {
            return true; // Le nom d'utilisateur existe déjà
        } else {
            return false; // Le nom d'utilisateur est disponible
        }
    }

    // Vérifie si la longueur d'une chaîne est en dehors des limites autorisées
    private function length($input, $min, $max) {
        if (strlen($input) < $min) {
            return true; // Trop court
        } else if (strlen($input) > $max) {
            return true; // Trop long
        }
    }

    // Retourne un message d'erreur HTML si l'erreur est présente dans le tableau des erreurs
    public function getErrorMessage($error) {
        if (in_array($error, $this->errorArray)) {
            return '<span class="errorMessage">' . $error . '</span>';
        }
    }
}
