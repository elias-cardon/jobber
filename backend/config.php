<?php
define("DB_HOST", "localhost");
define("DB_NAME", "jobber");
define("DB_USER", "jobba");
define("DB_PASS", "password");

$public_end = strpos($_SERVER['SCRIPT_NAME'],"/frontend")+8;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);

define("WWW_ROOT", $doc_root);
//echo BASE_URL;

//$servername = "localhost";
//$username = "jobba";
//$password = "password"; // A changer au moment du déploiement
//
//try {
 //   $pdo = new PDO("mysql:host=$servername;dbname=jobber", $username, $password);
//    //Set the PDO error mode to exception
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e){
//    echo "Connection failed: " . $e->getMessage();
//}