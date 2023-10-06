<?php

ob_start();

date_default_timezone_set("Europe/Paris");

require_once "config.php";
include "classes/PHPMailer.php";
include "classes/Exception.php";
include "classes/SMTP.php";

spl_autoload_register(function ($class) {
    require_once "classes/{$class}.php";
});

session_start();

$account = new Account;
$loadFromUser = new User;
$verify = new Verify;

include_once "functions.php";