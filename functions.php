<?php
	require("../../config.php");
	//See fail peab olema seotud k�igiga, kus tahame sessiooni kasutada
	//Saab kasutada n��d $_SESSION muutujat
	session_start();
	$database = "if16_aarovidevik";
	//function.php
	
	function signup($email, $password) {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?, ?)");
		echo $mysqli->error;
		
		//asendan k�sim�rgid
		//iga m�rgi kohta tuleb lisada �ks t�ht ehk mis t��pi muutuja on
		// s - string
		// i - interface_exists
		// d - double
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			echo "�nnestus";
		} else {
			echo "ERROR".$stmt->error;
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
		
		// m��ran muutujad reale mis k�tte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		// ainult SLECTI'i puhul
		if ($stmt->fetch()) {
			
			// v�hemalt �ks rida tuli
			// kasutaja sisselogimise parool r�siks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				// �nnestus 
				echo "Kasutaja ".$id." logis sisse";
				
			$_SESSION["userId"] = $id ;
			$_SESSION["userEmail"] = $emailFromDb;
			
			header("Location: data.php");
				exit();
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud �htegi rida
			$notice  =  "Sellist emaili ei ole!";
		}
		return $notice;
	}
	
	
	function tabelisse($age, $color) {
	
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("INSERT INTO whistle (age, color) VALUE (?, ?)");
	echo $mysqli->error;
	
	//asendan k�sim�rgi
	$stmt->bind_param("is", $age, $color);
	
	if($stmt->execute()) {
			echo "�nnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	

	}
	$id = "";
	$description = "";
	$location = "";
	$date = "";
	$url = "";
	function tabelisse2 ($description, $location, $date, $url) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO Nature (kirjeldus, asukoht, kuup�ev, url)  VALUES (?,?,?,?)");
		
		$stmt->bind_param("ssss", $description, $location, $date,$url);
		
		if ($stmt->execute()) {
			
			echo "Edukalt postitatud! <br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
	
	

  function getAllNature() {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, kirjeldus, asukoht, kuup�ev, url FROM Nature");
		$stmt->bind_result($id, $description, $location, $date, $url);
		$stmt->execute();
		
		$results = array();
		
		while($stmt->fetch()) {
			
			$nature = new StdClass();
			$nature->id = $id;
			$nature->description = $description;
			$nature->location = $location;
			$nature->day = $date;
			$nature->url = $url;
	
			
			
			array_push($results, $nature);
			
		}
		
		return $results;
		
	}
	
	
	
	
?>