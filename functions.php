<?php
	
		require("../../config.php");
		
	session_start();
	//et saab kasutada $_SESSION muutujaid
	//kõigis failies mis on selle failiga seotud
	$database = "if16_brigitta";
	//var_dump(%GLOBALS);
	
	function signup($email, $password) {
			
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES(?,?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if ($stmt->execute() ) {
			
			echo "saving success";
		} else {
			
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email=? ");
		
		$stmt->bind_param("s", $email);
		//määran muutujad reale mille kätte saan
		
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul 
		if ($stmt->fetch()) {
			
			//vähemalt 1 rida andmeid tuli läbi
			
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				//õnnestus
				echo "user ".$id." logged in";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			} else {
				$notice = "wrong password";
			}
				
			
			
		} else {
			//ei leitud ühetgi rida
			$notice = "there's no email like that!";
			
		}
		return $notice;
	}
		
		
	function saveNote($note, $color) {
			
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color) VALUES(?,?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $note, $color);
		
		if ($stmt->execute() ) {
			
			echo "saving success";
		} else {
			
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	
	function getAllNotes() 	{
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, note, color FROM colorNotes");
		
		$stmt->bind_result($id, $note, $color);
		$stmt->execute();
		
		$result = array();
		
		//tsükkel töötab seni kuni saab uue rea andmebaasist
		//nii mitu korda kui SELECT lausega tuli
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
		//" hello "
		$input = trim($input);
		//"hello"
		
		//"hel\\o"
		$input = stripslashes($input);
		//"hello"
		
		//"<"
		$input =  htmlspecialchars($input);
		//"&lt"
		
		return $input;
	}
	

	
	/*function hello($firstname, $lastname) {
		
		return "welcome ".$firstname." ".$lastname."!";
	}
	echo hello("Brigitta", "Kannel")
	
	*/
?>