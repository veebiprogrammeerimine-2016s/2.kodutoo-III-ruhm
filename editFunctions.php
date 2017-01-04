<?php
 
 	require_once("../../../../kristel/config.php");
 	
 	$database = "if16_krisroos_3";
	
    
 	
 	function getSingleNoteData($edit_id){
     
 		//echo "id on ".$edit_id;
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
 		
 		$stmt = $mysqli->prepare("SELECT color, profession, location, money, note FROM colornotes WHERE id=? AND deleted IS NULL");
 
 		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result( $color, $profession, $location, $money, $note);
 		$stmt->execute();
 		
 		//tekitan objekti
 		$n = new Stdclass();
 		
 		//saime ühe rea andmeid
 		if($stmt->fetch()){
 			// saan siin alles kasutada bind_result muutujaid
 			$n->note = $note;
 			$n->color = $color;
			$n->profession = $profession;
			$n->location = $location;
			$n->money = $money;
 			
 			
 		}else{
 			// ei saanud rida andmeid kätte
 			// sellist id'd ei ole olemas
 			// see rida võib olla kustutatud
 			header("Location: data.php");
 			exit();
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 		return $n;
 		
 	}
 
 
 	function updateNote($id, $color, $profession, $location, $money, $note){
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
 		
 		$stmt = $mysqli->prepare("UPDATE colornotes SET color=?, profession=?, location=?, money=?, note=? WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("sssisi", $color, $profession, $location, $money, $note, $id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
	function deletenote($id){
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
 		
 		$stmt = $mysqli->prepare("UPDATE colornotes 
		
		SET deleted=NOW() WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("i", $id);
 	
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
 	
 	
 ?> 