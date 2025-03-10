<?php
// Démarre la mise en mémoire tampon de sortie
// Permet de stocker temporairement la sortie avant de l'envoyer au navigateur
// Utile pour gérer les en-têtes HTTP ou modifier dynamiquement le contenu avant affichage
ob_start();

// Définit le fuseau horaire par défaut sur "Europe/Paris"
// Cela garantit que toutes les fonctions de date/heure utilisent cette configuration
date_default_timezone_set("Europe/Paris");

// Inclut le fichier de configuration qui définit les constantes de connexion à la base de données
// Contient généralement des informations comme l'hôte, le nom d'utilisateur, le mot de passe et la base de données
require_once "config.php";

// Charge automatiquement les classes PHP du dossier "classes"
// La fonction `spl_autoload_register` permet de charger dynamiquement une classe lorsqu'elle est instanciée
// Cela évite d'inclure manuellement chaque fichier de classe
spl_autoload_register(function ($class) {
    require_once "classes/" . $class . ".php";
});

// Démarre une session PHP pour stocker et gérer les données utilisateur
// Les sessions permettent de conserver des informations entre différentes pages (ex : utilisateur connecté)
session_start();

// Instancie la classe Account pour gérer l'authentification et l'inscription des utilisateurs
$account = new Account();

// Instancie la classe User pour récupérer et manipuler les données des utilisateurs enregistrés
$loadFromUser = new User();

// Inclut le fichier contenant des fonctions utilitaires globales
// Ces fonctions peuvent être utilisées partout dans le projet sans avoir besoin de réécrire du code redondant
include_once "functions.php";

