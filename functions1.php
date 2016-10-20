<?php

	require("../../../config.php");

	// functions.php
	session_start();

	$database = "if16_elleivan";

	//var_dump($GLOBALS);
	
	function signup($username, $email, $password) {
		
	
		$mysqli = new mysqli(

		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]
		
		);
              
		$stmt = $mysqli->prepare("INSERT INTO Aruanne (username, email, password) VALUES (?, ?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("sss", $username, $email, $password );

		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;	

		}
		
		
		
	}

	

	function login($username, $password) {

		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, username, email, password, created FROM Aruanne WHERE username = ? OR email = ?");

		//asendan ?
		$stmt->bind_param("ss", $username, $username);

		// määran muutujad reale mis kätte saan
		$stmt->bind_result($id, $usernameFromDb, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		//ainult SELECTI puhul
		if ($stmt->fetch()) {

			//vähemalt üks rida tuli
			//kasutaja sisselogimis parool räsiks
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {

				// õnnestus
				echo "Kasutaja ".$id." logis sisse";

				$_SESSION["userId"] = $id;
				$_SESSION["userUsername"] = $usernameFromDb;
				$_SESSION["userEmail"] = $emailFromDb;

				header("Location: data1.php");
				exit();
				

			} else {

				$notice = "Vale parool!";
			}


		} else {

			//ei leitud ühtegi rida
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
			echo "salvestamine õnnestus";
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

		while ( $stmt->fetch() ) {
			//echo $note."<br>";

			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->noteColor = $color;


			array_push($result, $object);
		}
		return $result;
}

function cleanInput($input) {
	// "  tere tulemast  "
	$input = trim($input);
	// "tere tulemast"

	// "tere \\tulemast"
	$input = stripslashes($input);
	// "tere tulemast"

	// "<"
	$input = htmlspecialchars($input);
	// "&lt;"

	return $input;
}

//return htmlspecialchars(stripslashes(trim($input)));
	/*function sum($x, $y) {
		$answer = $x+$y;
	
		return $answer;
	}
	
	function hello($firstname, $lastname) {
	
		return "Tere Tulemast ".$firstname." ".$lastname."!";
	}
	
	
	echo sum(123467162, 16235173476);
	echo "<br>";
	echo sum(1,2);
	echo "<br>";
	echo hello("Elle", "I.");
	*/
?>