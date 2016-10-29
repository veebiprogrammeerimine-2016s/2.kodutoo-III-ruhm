<?php 
	// functions.php
	require("../../config.php");
	
	// et saab kasutada $_SESSION muutujaid
	// kõigis failides mis on selle failiga seotud
	session_start(); 
	
	
	$database = "if16_gittkaus_3";
	
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
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud ühtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	function saveData ($email, $band, $song, $genre) {
		
		$database = "if16_gittkaus_3";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_music(email, band, song, genre) VALUES (?, ?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $email, $band, $song, $genre);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getMusicData() {
	
		$database = "if16_gittkaus_3";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		$stmt = $mysqli->prepare("
		
		SELECT id, email, band, song, genre
		FROM user_music
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $email, $band, $song, $genre);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while($stmt->fetch()) {
			
			
		//tekitan objekti
		$i = new StdClass();
		
		$i->id = $id;
		$i->email = $email;
		$i->band = $band;
		$i->song = $song;
		$i->genre = $genre;
		
		
		//echo $plate."<br>";
		//igakord massiivi lisan juurde nr märgi
		array_push($result, $i);				
		}
			
		
			
		$stmt->close();
		$mysqli->close();
		
		return $result;
		
	}
	
	function cleanInput ($input) {
		
		
		$input = trim($input);
		
		$input = stripslashes($input);
		
		$input = htmlspecialchars($input);
		
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
	
	$firstname = "Romil";
	
	echo hello($firstname, "R.");
	*/
?>