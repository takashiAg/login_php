<?php

require_once "login.php";

$login = new login();


//$e = $login->login("ryo@ando.link", "12345678");
$e = $login->signup("ando","crawd4274@gmail.com", "12345678");

var_dump($e);