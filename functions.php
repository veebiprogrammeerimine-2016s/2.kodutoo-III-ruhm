<?php

	require("../../config.php");
	
	//et saab kasutada $_SESSION muutujaid
	//kõigis failides mis on sellega seotud
	session_start();
	
	
	$database = "if16_kaspnou";
	
	//var_dump($GLOBALS);
	
	function signup($email, $password, $creditcardnr, $cscnr, $street, $city, $postalcode) {
		
		//ühendus
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, creditcardnr, cscnr, street, city, postalcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
		
		echo $mysqli->error;
		
		// s - string
		// i - int
		// d - decimal/double
		// iga küsimärgi jaoks üks täht, mis tüüpi on
		$stmt->bind_param("sssssss", $email, $password, $creditcardnr, $cscnr, $ctreet, $city, $postalcode);
		
		if($stmt->execute() ) {
			echo "salvestamine õnnestus";
		} else 	{
			echo "error ".$stmt->error;
		}	
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ? ");
		//asendan ?
		$stmt->bind_param("s", $email);
		//määran muutujad reale mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		//ainult SELECTI puhul
		if ($stmt->fetch()){
			//vähemalt üks rida tuli
			//kasutaja sisselogimise parool räsiks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				//õnnestus
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			}else{
				$notice = "Vale parool!";
			}
		}else {
			//ei leitud sellist rida
			$notice = "Sellist emaili ei ole!";
			
		}
		
		return $notice;
	
	}
	function saveNote($note, $color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
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
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		$stmt = $mysqli->prepare("
			SELECT id, note, color
			FROM colorNotes
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $note, $color);
		$stmt->execute();
		
		$result = array();
		
		// tsükkel töötab seni, kuni saab uue rea AB'i
		// nii mitu korda palju SELECT lausega tuli
		while ($stmt->fetch()) {
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
		// "   tere tulemast   "
		$input = trim($input);
		// "tere tulemast"
		
		
		// "tere \\tulemast"
		$input = stripslashes($input);
		// "tere tulemast"
		
		
		// "<"
		$input = htmlspecialchars($input);
		//" lt"
		
		return $input;
	}
	
	function saveInterest ($interest) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO interests (interest) VALUES (?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function saveUserInterest ($interest) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("
			SELECT id FROM user_interests_3 
			WHERE user_id=? AND interest_id=?
		");
		echo $mysqli->error;
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		
		$stmt->execute();
		
		//kas oli olemas
		if ($stmt->fetch()) {
			
			// oli olemas, ei salvesta
			echo "juba olemas";
			return; // see katkestab funktsiooni, edasi ei loe koodi
		}
		
		$stmt->close();
		// lähme edasi ja salvestamine
		
		$stmt = $mysqli->prepare("
			INSERT INTO user_interests_3 
			(user_id, interest_id) 
			VALUES (?, ?)
		");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getAllInterests() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, interest
			FROM interests
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->id = $id;
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	
	
	/*function sum($x, $y) {
	
		return $x+$y;
	
	}
	
	
	
	echo sum(1085252, 5198511654198);
	echo "<br>";
	
	echo sum(4, 5);
	echo "<br>";
	
	function hello($firstName, $lastName) {
		
		return "Tere tulemast " 
		.$firstName
		." "
		.$lastname
		."!"; 
		
	}
	
	$firstName = "Kaspar";
	$lastName = "nou"
	echo hello($firstName, $lastName);*/
	
	
	
	
	
	


?>