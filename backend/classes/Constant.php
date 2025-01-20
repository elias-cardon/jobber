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
}
