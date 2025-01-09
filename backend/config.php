<?php
define("DB_HOST", "localhost");
define("DB_NAME", "jobber");
define("DB_USER", "jobba");
define("DB_PASS", "password");

$public_end = strpos($_SERVER['SCRIPT_NAME'],"/frontend")+8;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);

define("WWW_ROOT", $doc_root);
//echo BASE_URL;