<?php 
	require_once("../../kristel/config.php");
	// functions.php
	// et saab kasutada $_SESSION muutujaid
	// kõigis failides mis on selle failiga seotud
	session_start();
	
	$database = "if16_krisroos_3";
	$mysqli = new mysqli ($serverHost, $serverUsername, $serverPassword, $database);
	
	require ("user.class.php");
	$User = new User($mysqli);
	
?>