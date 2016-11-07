<?php

	require("../../../config.php");

	// functions.php
	session_start();

	/* ÜHENDUS */
	$database = "if16_elleivan";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	require("user.class.php");
	$User = new User($mysqli);

	//echo $User->name;


function saveNote($note, $color, $r100, $r50, $r20, $r10, $r5, $r2, $r1) {
		
	
		$mysqli = new mysqli(

		$GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]
		
		);
              
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color, r100, r50, r20, r10, r5, r2, r1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("ssiiiiiii", $note, $color, $r100, $r50, $r20, $r10, $r5, $r2, $r1 );

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
              
		$stmt = $mysqli->prepare("SELECT id, note, color, r100, r50, r20, r10, r5, r2, r1 FROM colorNotes WHERE deleted IS NULL");
		$stmt->bind_result($id, $note, $color, $r100, $r50, $r20, $r10, $r5, $r2, $r1);
		$stmt->execute();

		$result = array();

		while ( $stmt->fetch() ) {
			//echo $note."<br>";

			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->noteColor = $color;
			$object->r100 = $r100;
			$object->r50 = $r50;
			$object->r20 = $r20;
			$object->r10 = $r10;
			$object->r5 = $r5;
			$object->r2 = $r2;
			$object->r1 = $r1;


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
		SELECT id FROM user_interests 
		WHERE user_id=? AND interest_id=?
		");
	echo $mysqli->error;
	$stmt->bind_param("ii", $_SESSION["userId"], $interest);

	$stmt->execute();

	//kas oli olemas
	if ($stmt->fetch()) {

		//oli olemas, ei salvesta
		echo "Juba olemas";	
		return; //see katkestab funktsiooni, edasi ei loe koodi
	}

	//lähme edasi ja salvestamine
	$stmt->close();


	$stmt = $mysqli->prepare("
		INSERT INTO user_interests 
		(user_id, interest_id) VALUES (?, ?)
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

	//tee seda seni, kuni on rida andmeid
	//mis vastab select lausele
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