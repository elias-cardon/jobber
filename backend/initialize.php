<?php
// Démarre la mise en mémoire tampon de sortie
ob_start();

// Définit le fuseau horaire à "Europe/Paris"
date_default_timezone_set("Europe/Paris");

// Inclut le fichier de configuration contenant les constantes de connexion à la base de données
require_once "config.php";

// Charge automatiquement les classes depuis le dossier "classes"
// Lorsque le nom d'une classe est utilisé, cette fonction inclut automatiquement son fichier
spl_autoload_register(function ($class) {
    require_once "classes/" . $class . ".php";
});

// Démarre une session PHP pour gérer les données utilisateur persistantes
session_start();

// Crée une instance de la classe Account pour gérer l'authentification et l'inscription des utilisateurs
$account = new Account();

// Inclut le fichier contenant les fonctions utilitaires
include_once "functions.php";
