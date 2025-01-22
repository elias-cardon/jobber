<?php

// Fonction pour vérifier si la requête reçue est de type POST
// Utilise la superglobale $_SERVER pour déterminer la méthode HTTP utilisée
// Retourne true si la méthode HTTP est 'POST', ce qui est souvent utilisé pour soumettre des formulaires
// Sinon, retourne false
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Fonction pour récupérer et afficher la valeur d'un champ de formulaire
// Prend en paramètre le nom du champ attendu dans le tableau $_POST ($name)
// Si une donnée a été soumise pour ce champ (i.e., la clé existe dans $_POST), elle affiche sa valeur
// Cela peut être utilisé pour conserver les données saisies dans le formulaire après une soumission
function getInputValue($name) {
    if (isset($_POST[$name])) {
        echo $_POST[$name]; // Affiche directement la valeur soumise
    }
}

// Fonction pour générer une URL complète en combinant un chemin de script
// Utilise une constante définie ailleurs dans l'application, `WWW_ROOT`
// Prend en paramètre $script, le chemin relatif du script à inclure dans l'URL
// Retourne une URL complète basée sur la racine du site définie par `WWW_ROOT`
function url_for($script) {
    return WWW_ROOT . $script;
}

// Fonction pour rediriger l'utilisateur vers une autre page ou emplacement
// Prend en paramètre $location, l'URL ou le chemin relatif où rediriger
// Utilise l'en-tête HTTP 'Location' pour effectuer la redirection
// Appelle `exit` après l'en-tête pour s'assurer qu'aucun code supplémentaire n'est exécuté après la redirection
function redirect_to($location) {
    header("Location:" . $location);
    exit;
}
