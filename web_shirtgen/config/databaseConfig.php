<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start();
//create a db  connection  via pdo 
define("servername", getenv("servername"));
define("database", getenv("database"));
define("username", getenv("username"));
define("password", getenv("password"));
define("alport", getenv("alport"));
//define("siteUrl_2", getenv("siteUrl_2"));
define("developer", true);
?>

