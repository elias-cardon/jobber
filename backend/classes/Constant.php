<?php

class Constant {
    // Message d'erreur pour un prénom qui ne respecte pas la longueur requise (2 à 25 caractères)
    public static $firstNameCharacters = "Le prénom doit comporter entre 2 et 25 caractères";

    // Message d'erreur pour un nom qui ne respecte pas la longueur requise (2 à 25 caractères)
    public static $lastNameCharacters = "Le nom doit comporter entre 2 et 25 caractères";

    // Message d'erreur pour une adresse email déjà utilisée
    public static $emailInUse = "Cette adresse email est déjà utilisée";

    // Message d'erreur pour une adresse email qui ne respecte pas un format valide
    public static $emailInvalid = "Cette adresse email est invalide";

    // Message d'erreur pour un mot de passe qui ne respecte pas la longueur requise (5 à 30 caractères)
    public static $passwordLength = "Le mot de passe doit comporter entre 5 et 30 caractères";

    // Message d'erreur pour des mots de passe qui ne correspondent pas
    public static $passwordDoNotMatch = "Les mots de passe ne correspondent pas";

    // Message d'erreur pour un mot de passe contenant des caractères non alphanumériques
    public static $passwordDoNotAlphanumeric = "Votre mot de passe doit seulement contenir des lettres et des chiffres";
}
