<?php

require_once "backend/initialize.php";

var_dump($loadFromUser->get("users",["*"],["user_id"=>11]));