<?php
	require("../../config.php");
	// functions.php
	//et saab kasutada $_SESSION muutujaid
	//kõigis failides, mis on sellega seotud
	session_start();
	
	$database = "if16_paulvase_3";
	//var_dump($GLOBALS);
	
	function signup($email, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO user_sample 
		(email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		
		if ( $stmt->execute() ) {
			
			echo "salvestamine õnnestus";
			
		} else {
			
			echo "ERROR ".$stmt->error;
		}
		
		
	}	
		
	function login($email, $password){
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		$stmt->bind_param("s", $email);

		//määran muutujad reale, mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
	
		$stmt->execute();
		
		//ainult SELECTI puhul 
		if($stmt->fetch()) {
			
			//vähemalt üks rida andmeid tuli läbi
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
				//õnnestus
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
			}else {
				$notice = "vale parool!";
				
								
			}
			
		} else {
			//ei leitud ühtegi rida
			$notice = "sellist emaili ei ole!";
		}
		return $notice;
	}

	
	function saveNote($note, $color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO kodutoo 
		(note, color) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $note, $color );
		
		if ( $stmt->execute() ) {
			
			echo "salvestamine õnnestus";	
		} else {
			echo "ERROR ".$stmt->error;
		}
		}
	
	
	function getAllNotes () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, note, color FROM kodutoo");
		
		$stmt->bind_result($id, $note, $color);
		$stmt->execute();
		
		$result = array();
		
		//tsükkel töötab seni, kuni saab uue rea AB'i 
		// nii mitu korda SELECT lausega tuli
		while($stmt->fetch()){
			//echo $note."<br>";
			
			$object = new StdClass ();
			$object->id=$id;
			$object->note=$note;
			$object->noteColor = $color;
			
			array_push($result, $object);
			
		}
		return $result;
	}
	
	function cleanInput($input) {
		 //return htmlspecialchars(stripslashes(trim($input); saab ka ühel real
		// "	tere tulemast	 "
		//"tere tulemast" teeb selliseks
		$input = trim($input);
		// "võtab \ ära"
		$input = stripslashes($input);
		// "< saab &lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
		
	}
	
	
	
	
	
	
?>