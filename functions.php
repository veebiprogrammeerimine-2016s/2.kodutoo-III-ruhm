<?php
	// functions.php
	
	require("../../config.php");
	// et saaks kasutada $_SESSION muutujaid
	// koigis failides mis on selle failiga seotud
	session_start();
	
	$database = "if16_richkaja_3";
	function signup($username, $email, $password, $gender, $birthdate) {
		$email = cleanInput($email);
		$mysqli = new mysqli($GLOBALS["serverHost"],
							$GLOBALS["serverUsername"],
							$GLOBALS["serverPassword"],
							$GLOBALS["database"]
							);
		$stmt = $mysqli->prepare("
		INSERT INTO login_data(username, email, password, gender, birthdate) VALUES(?, ?, ?, ?, ?)
		");
		// s, i, d
		echo $mysqli->error;
		$stmt->bind_param("sssss", $username, $email, $password, $gender, $birthdate);
		
		if ($stmt -> execute() ) {
			echo "salvestamine onnestus";
		}else{
			
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	
	function login ($username, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],
							$GLOBALS["serverUsername"],
							$GLOBALS["serverPassword"],
							$GLOBALS["database"]
							);
		$stmt = $mysqli->prepare("
		
			SELECT id, username, email, password, gender, birthdate, created
			FROM login_data
			WHERE username = ?
		");
		// asendan ?
		echo $mysqli ->error;
		$stmt -> bind_param("s", $username);
		// määran muutujad reale mis kätte saan
		$stmt -> bind_result($id, $usernameFromDb, $emailFromDb,
							$passwordFromDb, $genderFromDb, $birthdateFromDb, $createdFromDb);
		$stmt->execute();
		// ainult SELECT'i puhul
		if($stmt -> fetch()) {
			
			//vahemalt uks rida tuli
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				//onnestus
				echo "Kasutaja ".$id." logis sisse";
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["username"] = $usernameFromDb;
				$_SESSION["gender"] = $genderFromDb;
				$_SESSION["birthdate"] = $birthdateFromDb;
				$_SESSION["created"] = $createdFromDb;
				header("Location: data.php");
				exit();
			} else {
				$notice = "Wrong password!";
			}
		} else {
			// ei leitud ühtegi rida nime kohta
			$notice = "Such username does not exist!";
		}
		
		return $notice;
	}
	
	function saveFeedback($feedback) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],
					$GLOBALS["serverUsername"],
					$GLOBALS["serverPassword"],
					$GLOBALS["database"]
					);
		$stmt = $mysqli->prepare("
		INSERT INTO feedback(userid, feedback) VALUES(?, ?)
		");
		// s, i, d
		echo $mysqli->error;
		$stmt->bind_param("is", $_SESSION["userId"], $feedback);
		
		if ($stmt -> execute() ) {
				echo "salvestamine onnestus";
		}else{
			
			echo "ERROR ".$stmt->error;
		}
	}
	
	function getFeedback() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],
			$GLOBALS["serverUsername"],
			$GLOBALS["serverPassword"],
			$GLOBALS["database"]
			);
			
		$stmt = $mysqli->prepare("
			SELECT login_data.username, feedback.feedback
			FROM feedback, login_data
			WHERE feedback.userid = login_data.id
		");
		//WHERE feedback.userid = ? AND login_data.id = feedback.userid
		//$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($username, $feedback);
		$stmt->execute();
		$result = array();
		while($stmt->fetch()) {
			$object = new StdClass();
			$object->username = $username;
			$object->feedback = $feedback;
			

			array_push($result, $object);
			
		}
		
		return $result;
		
	}
	function cleanInput($input) {
		
		return htmlspecialchars(stripslashes(trim(($input))));
	}
?>