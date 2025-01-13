<?php
// Définition des constantes de connexion à la base de données
define("DB_HOST", "localhost");  // Hôte de la base de données
define("DB_NAME", "jobber");     // Nom de la base de données
define("DB_USER", "jobba");      // Nom d'utilisateur de la base de données
define("DB_PASS", "password");   // Mot de passe de la base de données

// Détermine la racine publique du site web
$public_end = strpos($_SERVER['SCRIPT_NAME'], "/frontend") + 8;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);   // Chemin de la racine web

//echo BASE_URL; // (Ligne de débogage désactivée)
