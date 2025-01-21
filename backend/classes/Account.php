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

        // Affiche les chemins d'image sélectionnés (pour le débogage ou test)
        echo $profilePic . "-" . $profileCover;
    }

    // Valide la longueur du prénom (entre 2 et 25 caractères)
    private function validateFirstName($fn) {
        // Vérifie si la longueur du prénom est hors des limites autorisées
        if ($this->length($fn, 2, 25)) {
            // Ajoute un message d'erreur spécifique au tableau des erreurs
            return array_push($this->errorArray, Constant::$firstNameCharacters);
        }
    }

    // Valide la longueur du nom (entre 2 et 25 caractères)
    private function validateLastName($ln) {
        // Vérifie si la longueur du nom est hors des limites autorisées
        if ($this->length($ln, 2, 25)) {
            // Ajoute un message d'erreur spécifique au tableau des erreurs
            return array_push($this->errorArray, Constant::$lastNameCharacters);
        }
    }

    // Valide les mots de passe (vérifie leur correspondance et leurs exigences)
    private function validatePassword($pw, $pw2) {
        // Vérifie si les deux mots de passe sont identiques
        if ($pw != $pw2) {
            // Ajoute un message d'erreur si les mots de passe ne correspondent pas
            return array_push($this->errorArray, Constant::$passwordDoNotMatch);
        }

        // Vérifie si le mot de passe contient uniquement des caractères alphanumériques
        if (preg_match("/[^A-Za-z0-9]/", $pw)) {
            // Ajoute un message d'erreur si des caractères spéciaux sont détectés
            return array_push($this->errorArray, Constant::$passwordDoNotAlphanumeric);
        }

        // Vérifie si la longueur du mot de passe respecte les limites autorisées
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
        $count = $stmt->rowCount();
        if ($count > 0) {
            // Ajoute un message d'erreur si l'email est déjà utilisé
            return array_push($this->errorArray, Constant::$emailInUse);
        }

        // Vérifie si le format de l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Ajoute un message d'erreur si le format est incorrect
            return array_push($this->errorArray, Constant::$emailInvalid);
        }
    }

    // Génère un nom d'utilisateur à partir du prénom et du nom
    public function generateUsername($fn, $ln) {
        // Vérifie que les champs prénom et nom ne sont pas vides
        if (!empty($fn) && !empty($ln)) {
            // Vérifie si les validations de prénom et de nom sont passées
            if (!in_array(Constant::$firstNameCharacters, $this->errorArray) && !in_array(Constant::$lastNameCharacters, $this->errorArray)) {
                // Crée un nom d'utilisateur en concaténant prénom et nom en minuscules
                $username = strtolower($fn . $ln);

                // Vérifie si ce nom d'utilisateur existe déjà
                if ($this->checkUsernameExist($username)) {
                    // Ajoute un nombre aléatoire pour générer un nom unique
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
        // Prépare une requête SQL pour vérifier l'existence
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Retourne `true` si le nom d'utilisateur existe, sinon `false`
        return $stmt->rowCount() > 0;
    }

    // Vérifie si la longueur d'une chaîne respecte les limites spécifiées
    private function length($input, $min, $max) {
        // Retourne vrai si la longueur est inférieure ou supérieure aux limites
        return strlen($input) < $min || strlen($input) > $max;
    }

    // Retourne un message d'erreur HTML si l'erreur existe dans le tableau des erreurs
    public function getErrorMessage($error) {
        // Vérifie si l'erreur est dans le tableau des erreurs
        if (in_array($error, $this->errorArray)) {
            // Retourne un message HTML formaté
            return '<span class="errorMessage">' . $error . '</span>';
        }
    }
}
