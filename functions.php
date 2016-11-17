<?php
require("/var/www/html/config.php");

//for using $_SESSION stuff
//in all files that are connected with functions.php
session_start();
$db = "logindb";
/*
require("User.class.php");
require("Note.class.php");
require("Interest.class.php");
require("Helper.class.php");
*/
$mysqli = new mysqli($serverHost,$serverUsername,$serverPassword,$db);
/*
$User = new User($mysqli);
$Note = new Note($mysqli);
$Interest = new Interest($mysqli);
$Helper = new Helper();
*/
?>
