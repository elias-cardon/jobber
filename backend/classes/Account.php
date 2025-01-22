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
    // Cette méthode valide les données d'entrée et prépare leur insertion dans la base de données
    public function register($fn, $ln, $un, $em, $pw, $pw2) {
        // Validation du prénom
        $this->validateFirstName($fn);

        // Validation du nom
        $this->validateLastName($ln);

        // Validation de l'email
        $this->validateEmail($em);

        // Validation des mots de passe
        $this->validatePassword($pw, $pw2);

        // Si aucune erreur n'est détectée, insère les détails utilisateur dans la base de données
        if (empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        } else {
            // Retourne `true` pour indiquer qu'il y a des erreurs
            return true;
        }
    }

    // Méthode pour insérer les détails utilisateur dans la base de données
    public function insertUserDetails($fn, $ln, $un, $em, $pw) {
        // Hachage du mot de passe pour une sécurité renforcée
        $pass_hash = password_hash($pw, PASSWORD_BCRYPT);

        // Génère un nombre aléatoire pour déterminer l'image de profil et la couverture
        $rand = rand(0, 2);

        // En fonction de la valeur aléatoire, sélectionne des images de profil et de couverture
        if ($rand == 0) {
            $profilePic = "frontend/assets/images/defaultProfilePic.png";
            $profileCover = "frontend/assets/images/backgroundProfileCover.svg";
        } else if ($rand == 1) {
            $profilePic = "frontend/assets/images/defaultPic.svg";
            $profileCover = "frontend/assets/images/backgroundImage.svg";
        } else if ($rand == 2) {
            $profilePic = "frontend/assets/images/profilePic.jpeg";
            $profileCover = "frontend/assets/images/backgroundProfileCover.svg";
        }

        // Prépare une requête pour insérer les informations utilisateur dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO users (firstName, lastName, username, email, password, profileImage, profileCover) VALUES (:fn, :ln, :un, :em, :pw, :pic, :cov)");
        $stmt->bindParam(':fn', $fn, PDO::PARAM_STR);
        $stmt->bindParam(':ln', $ln, PDO::PARAM_STR);
        $stmt->bindParam(':un', $un, PDO::PARAM_STR);
        $stmt->bindParam(':em', $em, PDO::PARAM_STR);
        $stmt->bindParam(':pw', $pass_hash, PDO::PARAM_STR);
        $stmt->bindParam(':pic', $profilePic, PDO::PARAM_STR);
        $stmt->bindParam(':cov', $profileCover, PDO::PARAM_STR);

        // Exécute la requête
        $stmt->execute();

        // Retourne l'ID de l'utilisateur inséré
        return $this->pdo->lastInsertId();
    }

    // Valide la longueur du prénom (entre 2 et 25 caractères)
    private function validateFirstName($fn) {
        if ($this->length($fn, 2, 25)) {
            // Ajoute un message d'erreur spécifique si la validation échoue
            return array_push($this->errorArray, Constant::$firstNameCharacters);
        }
    }

    // Valide la longueur du nom (entre 2 et 25 caractères)
    private function validateLastName($ln) {
        if ($this->length($ln, 2, 25)) {
            return array_push($this->errorArray, Constant::$lastNameCharacters);
        }
    }

    // Valide les mots de passe (vérifie leur correspondance et leurs exigences)
    private function validatePassword($pw, $pw2) {
        // Vérifie si les deux mots de passe correspondent
        if ($pw != $pw2) {
            return array_push($this->errorArray, Constant::$passwordDoNotMatch);
        }

        // Vérifie si le mot de passe contient uniquement des caractères alphanumériques
        if (preg_match("/[^A-Za-z0-9]/", $pw)) {
            return array_push($this->errorArray, Constant::$passwordDoNotAlphanumeric);
        }

        // Vérifie si la longueur du mot de passe respecte les limites autorisées
        if ($this->length($pw, 5, 30)) {
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
        if ($stmt->rowCount() > 0) {
            return array_push($this->errorArray, Constant::$emailInUse);
        }

        // Vérifie si le format de l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array_push($this->errorArray, Constant::$emailInvalid);
        }
    }

    // Génère un nom d'utilisateur à partir du prénom et du nom
    public function generateUsername($fn, $ln) {
        if (!empty($fn) && !empty($ln)) {
            if (!in_array(Constant::$firstNameCharacters, $this->errorArray) && !in_array(Constant::$lastNameCharacters, $this->errorArray)) {
                $username = strtolower($fn . $ln);

                if ($this->checkUsernameExist($username)) {
                    $screenRand = rand();
                    $userLink = $username . $screenRand;
                } else {
                    $userLink = $username;
                }

                return $userLink;
            }
        }
    }

    // Vérifie si un nom d'utilisateur existe déjà dans la base de données
    private function checkUsernameExist($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Vérifie si la longueur d'une chaîne respecte les limites spécifiées
    private function length($input, $min, $max) {
        return strlen($input) < $min || strlen($input) > $max;
    }

    // Retourne un message d'erreur HTML si l'erreur existe dans le tableau des erreurs
    public function getErrorMessage($error) {
        if (in_array($error, $this->errorArray)) {
            return '<span class="errorMessage">' . $error . '</span>';
        }
    }
}
