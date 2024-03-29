<?php

function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

function url_for($script){
    return WWW_ROOT.$script;
}

function redirect_to($location){
    header("Location:".$location);
    exit;
}