<?php

class User {
    // Instance de l'objet PDO pour l'interaction avec la base de données
    private $pdo;

    // Constructeur de la classe User
    // Initialise la connexion à la base de données en obtenant une instance unique via le modèle singleton
    public function __construct() {
        $this->pdo = Database::instance();
    }

    // Récupère les données d'un utilisateur en fonction de son identifiant unique (user_id)
    // Retourne un objet contenant les informations de l'utilisateur si trouvé, sinon retourne false
    public function userData($user_id) {
        // Prépare une requête SQL sécurisée pour éviter les injections SQL
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :userId");

        // Lie la valeur du paramètre `:userId` avec la variable `$user_id`, en s'assurant que c'est un entier
        $stmt->bindParam(":userId", $user_id, PDO::PARAM_INT);

        // Exécute la requête préparée
        $stmt->execute();

        // Récupère le résultat sous forme d'objet
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        // Vérifie si l'utilisateur existe dans la base de données
        if ($stmt->rowCount() != 0) {
            return $user; // Retourne l'objet contenant les informations de l'utilisateur
        } else {
            return false; // Retourne false si aucun utilisateur trouvé
        }
    }
}
