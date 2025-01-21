<?php

// Fonction pour vérifier si la requête reçue est de type POST
// Retourne true si la méthode HTTP utilisée est POST, false sinon
function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Fonction pour récupérer la valeur d'un champ de formulaire
// Prend en paramètre le nom du champ ($name)
// Si la clé existe dans $_POST, elle affiche sa valeur
function getInputValue($name){
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
