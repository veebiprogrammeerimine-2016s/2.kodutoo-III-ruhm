<?php
	require_once("../config.php");
	$database = "if16_edgar";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	// functions.php
	
	//et saab kasutada $_SESSION muutujaid
	
	//kõigist faildes mis on selle failiga seotud
	
	session_start();
	
	
	$database = "if16_edgar";
	//var_dump($GLOBALS);
	
	function signup($email, $password) {
		
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO logindata (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
	}	
	
	
	function login($email, $password) {
		
		$notice="";
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM logindata
			WHERE email = ? 
		
		");
		//asendan ?	
		$stmt->bind_param("s", $email);
		
		// m22ran muutujad reale mis katte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul
		if ($stmt->fetch()) {
			
			//v2hemalt yks rida tuli
			//kasutaja sisselogimise parool r2siks
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				//6nnestus
				echo "Kasutaja ", $id, " loggis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			} else {
				$notice = "Vale parool";
					
				}
			
			
		} else {
			//ei leitud ythegi rida
			$notice =  "Sellist emaili ei ole!";
			
		}
		return $notice;
	}
	
	function saveNote($firstname,$lastname,$notebook,$serialnumber,$priority,$note,$color,$comment) {
		
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO notebookRepair (firstname,lastname,notebook,serialnumber,priority,note,color,comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssssssss", $firstname,$lastname,$notebook,$serialnumber,$priority,$note,$color,$comment);
		
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
	}				
	
	function getAllNotes() {
		
		$mysqli = new mysqli (
		
		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, firstname, lastname, notebook, serialnumber, priority, note, color, comment 
		FROM notebookRepair
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $firstname, $lastname, $notebook, $serialnumber, $priority, $note, $color, $comment);
		$stmt->execute();
		
		$result = array();
		
		
		//tsukkel tootab seni, kuni saab uue rea AB'i
		//nii mitu korda palju SELECT lausega tuli
		while($stmt->fetch()) {
			//echo $note,"<br>";
			
			
			$object = new StdClass();
			$object->id = $id ;
			$object->firstname = $firstname;
			$object->lastname = $lastname;
			$object->notebook = $notebook;
			$object->serialnumber = $serialnumber;
			$object->priority = $priority;
			$object->note = $note;
			$object->noteColor = $color;
			$object->comment = $comment;
			
			
			array_push($result, $object);
		}
		
		return $result;
	}
	
	
	

	/*function sum($x, $y) {
			
		$answer = $x + $y;
	
		return $answer;
	
	}
	
	
	echo sum(1,2);
	echo "<br>";
	echo sum(12345,231313);
	echo "<br>";
	
	function hello($firstname, $lastname) {
		
		return "Tere tulemast, ".$firstname." ".$lastname."!";	
		
		
	}
	
	echo hello("Edgar", "Selihov");
	*/
?>