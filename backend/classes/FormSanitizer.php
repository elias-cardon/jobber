<?php

class FormSanitizer {
    // Nettoie une chaîne de caractères en supprimant les balises HTML, les espaces inutiles
    // et en convertissant les caractères spéciaux en entités HTML
    public static function formSanitizerString($data) {
        $data = trim(strip_tags($data));     // Supprime les balises HTML et les espaces en début/fin
        $data = htmlspecialchars($data);     // Convertit les caractères spéciaux pour éviter les injections XSS
        return $data;
    }

    // Nettoie et formate un nom propre : supprime les balises HTML, les espaces,
    // convertit en minuscules puis met la première lettre en majuscule
    public static function formSanitizerName($data) {
        $data = trim(strip_tags($data));     // Supprime les balises HTML et les espaces en début/fin
        $data = htmlspecialchars($data);     // Convertit les caractères spéciaux pour éviter les injections XSS
        $data = strtolower($data);           // Convertit la chaîne en minuscules
        $data = ucfirst($data);              // Met la première lettre en majuscule
        return $data;
    }
}
