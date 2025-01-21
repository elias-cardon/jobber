<?php

class Account {
    // Instance PDO pour interagir avec la base de données
    private $pdo;

    // Tableau pour stocker les messages d'erreur liés à la validation
    private $errorArray = array();

    // Constructeur : initialise la connexion à la base de données
    public function __construct() {
        // Obtient l'instance unique de la classe Database (singleton)
        $this->pdo = Database::instance();
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

        // Validation du mot de passe
        $this->validatePassword($pw, $pw2);

        // Si le tableau des erreurs est vide, insère les données utilisateur dans la base
        if (empty($this->errorArray)) {
            return $this->insertUserData($fn, $ln, $un, $em, $pw);
        } else {
            // Retourne vrai pour indiquer qu'il y a des erreurs
            return true;
        }
    }

    // Insère les données utilisateur dans la base de données (méthode à compléter)
    public function insertUserData($fn, $ln, $un, $em, $pw) {
        // TODO : Ajouter la logique d'insertion des données dans la base
        return true;
    }

    // Valide la longueur du prénom (entre 2 et 25 caractères)
    private function validateFirstName($fn) {
        // Vérifie si la longueur du prénom est hors des limites autorisées
        if ($this->length($fn, 2, 25)) {
            // Ajoute un message d'erreur si la validation échoue
            return array_push($this->errorArray, Constant::$firstNameCharacters);
        }
    }

    // Valide la longueur du nom (entre 2 et 25 caractères)
    private function validateLastName($ln) {
        // Vérifie si la longueur du nom est hors des limites autorisées
        if ($this->length($ln, 2, 25)) {
            // Ajoute un message d'erreur si la validation échoue
            return array_push($this->errorArray, Constant::$lastNameCharacters);
        }
    }

    // Valide les mots de passe (confirmation et exigences)
    private function validatePassword($pw, $pw2) {
        // Vérifie si les mots de passe correspondent
        if ($pw != $pw2) {
            // Ajoute un message d'erreur si les mots de passe ne correspondent pas
            return array_push($this->errorArray, Constant::$passwordDoNotMatch);
        }

        // Vérifie si le mot de passe contient uniquement des caractères alphanumériques
        if (preg_match("/[^A-Za-z0-9]/", $pw)) {
            // Ajoute un message d'erreur si des caractères spéciaux sont détectés
            return array_push($this->errorArray, Constant::$passwordDoNotAlphanumeric);
        }

        // Vérifie si la longueur du mot de passe est hors des limites autorisées
        if ($this->length($pw, 5, 30)) {
            // Ajoute un message d'erreur si la longueur est incorrecte
            return array_push($this->errorArray, Constant::$passwordLength);
        }
    }

    // Valide l'email
    private function validateEmail($email) {
        // Prépare une requête pour vérifier si l'email existe déjà dans la base de données
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Vérifie si l'email est déjà utilisé
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
        // Vérifie que les champs prénom et nom ne sont pas vides
        if (!empty($fn) && !empty($ln)) {
            // Vérifie si les champs prénom et nom passent la validation
            if (!in_array(Constant::$firstNameCharacters, $this->errorArray) && !in_array(Constant::$lastNameCharacters, $this->errorArray)) {
                // Concatène le prénom et le nom en minuscules
                $username = strtolower($fn . $ln);

                // Vérifie si le nom d'utilisateur existe déjà
                if ($this->checkUsernameExist($username)) {
                    // Génère un nom d'utilisateur unique en ajoutant un nombre aléatoire
                    $screenRand = rand();
                    $userLink = $username . $screenRand;
                } else {
                    $userLink = $username;
                }

                // Retourne le nom d'utilisateur généré
                return $userLink;
            }
        }
    }

    // Vérifie si un nom d'utilisateur existe déjà dans la base de données
    private function checkUsernameExist($username) {
        // Prépare une requête pour vérifier si le nom d'utilisateur existe
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Retourne vrai si le nom d'utilisateur existe, faux sinon
        return $stmt->rowCount() > 0;
    }

    // Vérifie si la longueur d'une chaîne est en dehors des limites autorisées
    private function length($input, $min, $max) {
        // Retourne vrai si la longueur est inférieure au minimum ou supérieure au maximum
        return strlen($input) < $min || strlen($input) > $max;
    }

    // Retourne un message d'erreur HTML si l'erreur est présente
    public function getErrorMessage($error) {
        // Vérifie si l'erreur existe dans le tableau des erreurs
        if (in_array($error, $this->errorArray)) {
            // Retourne le message d'erreur au format HTML
            return '<span class="errorMessage">' . $error . '</span>';
        }
    }
}
