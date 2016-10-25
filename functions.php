<?php 
	// functions.php
	require("../../config.php");
	// et saab kasutada $_SESSION muutujaid
	// kõigis failides mis on selle failiga seotud
	session_start();
	
	
	$database = "if16_kliiva";
	
	//var_dump($GLOBALS);
	
	function signup($signupEmail, $password, $signupTelephone, $signupUsername) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, Telephone, username) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssis", $signupEmail, $password, $signupTelephone, $signupUsername );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		// asendan ?
		$stmt->bind_param("s", $email);
		
		// määran muutujad reale mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		// ainult SLECTI'i puhul
		if ($stmt->fetch()) {
			
			// vähemalt üks rida tuli
			// kasutaja sisselogimise parool räsiks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				// õnnestus 
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud ühtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	function getAllFPosts() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, forumPost FROM forumPosts");
		
		$stmt->bind_result($id, $forumPost);
		$stmt->execute();
		
		$result = array();
		
		while($stmt->fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id = $id;
			$object->forumPost = $forumPost;
			
			array_push($result, $object);
		}
		
		return $result;
		
	}
	
	function saveFPost($forumPost) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO forumPosts (forumPost) VALUES (?)");
		echo $mysqli->error;
		
		$stmt->bind_param("s", $forumPost);
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	if (	isset($_POST["forumPost"]) && 
			!empty($_POST["forumPost"])
	) {
		
		$forumPost = cleanInput($_POST["forumPost"]);
		
	}
	
	function cleanInput ($input) {
		
		//algul - " tere tulemast "
		$input = trim($input);
		//sellega koos - "tere tulemast"
		
		$input = stripslashes($input);
		
		//"<"
		$input = htmlspecialchars($input);
		//"&lt"
		
		return $input;
	}
?>