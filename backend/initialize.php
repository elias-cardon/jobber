<?php
// Démarre la mise en mémoire tampon de sortie
ob_start();

// Définit le fuseau horaire à "Europe/Paris"
date_default_timezone_set("Europe/Paris");

// Inclut le fichier de configuration
require_once "config.php";

// Charge automatiquement les classes depuis le dossier "classes"
spl_autoload_register(function ($class) {
    require_once "classes/" . $class . ".php";
});

// Démarre une session PHP
session_start();

// Inclut le fichier contenant les fonctions utilitaires
include_once "functions.php";
