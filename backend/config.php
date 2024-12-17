<?php

$servername = "localhost";
$username = "jobba";
$password = "password"; // A changer au moment du déploiement

try {
    $pdo = new PDO("mysql:host=$servername;dbname=jobber", $username, $password);
    //Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}