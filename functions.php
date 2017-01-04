<?php 
	require("../../../../kristel/config.php");
	// functions.php
	// et saab kasutada $_SESSION muutujaid
	// kõigis failides mis on selle failiga seotud
	session_start();
	$database = "if16_krisroos_3";
	$mysqli = new mysqli ($serverHost, $serverUsername, $serverPassword, $database);
	
	require ("user.class.php");
	$User = new User($mysqli);
	
	
	
	//var_dump($GLOBALS);
	
	
	
	function saveNote($profession, $location, $money, $color, $note) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO colornotes (profession, location, money, color, note) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//bind-param konrollib, et ei saaks jama sisestada lünka
		$stmt->bind_param("ssiss", $profession, $location, $money, $color, $note );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllNotes (){
		
		$mysqli = new mysqli (
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		
		$stmt = $mysqli ->prepare("
		SELECT id, profession, color, location, money, note
		FROM colornotes
		WHERE deleted IS NULL"
		
		);
		
		$stmt->bind_result($id, $profession, $color, $location, $money, $note);
		$stmt->execute();
		$result = array();
		
		// tsükkel tõõtab seni, kuni saab uue rea AB-i base_add_user
		//nii mitu korda palju SELECT
		while ($stmt -> fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id= $id;
			$object->note= $note;
			$object->noteColor = $color;
			$object->profession = $profession;
			$object->location = $location;
			$object->money = $money;
			
			array_push($result, $object);
		}
		return $result;
	}
		
	
	function cleanInput ($input){
		//enne oon " tere tulemast "
		$input = trim($input);
		//pärast selle koodi sisestamist "tere tulemast"
		$input = stripslashes($input); //paneb tagurpidi kaldkriisud õieti
		//"<"
		$input = htmlspecialchars ($input);
		// "&lt;"
		
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
		
		SELECT id FROM user_intrests_3 
 			WHERE user_id=? AND intrest_id=?
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
 			INSERT INTO user_intrests_3 
 			(user_id, intrest_id) 
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
	
	$firstname = "Kristel";
	
	echo hello($firstname, "K.");
	*/
?>