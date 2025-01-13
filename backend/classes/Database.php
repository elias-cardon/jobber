<?php

class Database {
    protected $pdo;              // Instance PDO pour la connexion à la base de données
    protected static $instance;  // Instance unique de la classe Database (singleton)

    // Constructeur protégé pour établir la connexion à la base de données
    protected function __construct() {
        try {
            $this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';', DB_USER, DB_PASS);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Méthode statique pour obtenir l'instance unique de la classe
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // Redirection des appels de méthodes vers l'instance PDO
    public function __call($method, $args) {
        return call_user_func_array(array($this->pdo, $method), $args);
    }
}
