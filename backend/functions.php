<?php

// Vérifie si la requête est de type POST
function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}
