<?php 

	require("../../config.php");
	
	// functions.php
	
	// et saab kasutada $_SESSION muutujaid
	// k?igis failides mis on selle failiga seotud
	session_start();
	
	
	$database = "if16_rolatall_3";
	
	//var_dump($GLOBALS);
	
	function signup($email, $password) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );

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
		
		// maaran muutujad reale mis katte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		// ainult SELECTI'i puhul
		if ($stmt->fetch()) {
			
			// vahemalt uks rida tuli
			// kasutaja sisselogimise parool r?siks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				// onnestus 
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud uhtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	
	
	
	
	
	function saveNote($note, $color) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);

		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $note, $color );

		if ( $stmt->execute() ) {
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	
	function getAllNotes() {
		
		$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		);
		
		$stmt = $mysqli->prepare("SELECT id, note, color FROM colorNotes");
		
		$stmt->bind_result($id, $note, $color);
		$stmt->execute();
		
		$result = array();
		
		// tsükkel töötab seni, kuni saab uue rea andmebaasist
		// nii mitu korda kui palju SELECT lausega tuli
		while($stmt->fetch()) {
			//echo $note."<br>";
			
			
			
			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->noteColor = $color;
			
			
			
			
			
			array_push($result, $object);
			
			
			
		}
		
		return $result;
	}
	
	
	function cleanInput ($input) {
		
		
		// "      tere tulemast     "
		$input = trim($input);
		// "tere tulemast"
		
		// "tere \\tulemast"
		$input = striplashes($input);
		// "tere tulemast"
		
		$input = htmlspecialchars($input);
		// "$lt;"
		
		return $input;
		
	}
	
	
	
	
	
	/*function sum($x, $y) {
		
		$answer = $x+$y;
		
		return $answer;
	}
	
	function hello($firstname, $lastname) {
		
		return 
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
		
	}
	
	echo sum(123123789523,1239862345);
	echo "<br>";
	echo sum(1,2);
	echo "<br>";
	
	$firstname = "Roland";
	
	echo hello($firstname, "T.");
	*/
?>



