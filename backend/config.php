<?php
$servername = "localhost";
$username = "tweety";
$password = "password";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=jobber",$username,$password);
    // set the pdo error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connexion échouée: ".$e->getMessage();
}