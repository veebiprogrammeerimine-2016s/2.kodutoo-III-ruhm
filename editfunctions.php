<?php
	require_once("config.php");
	
	$db = "logindb";
	
	function getSingleNoteData($edit_id){
    
		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["db"]);
		
		$stmt = $mysqli->prepare("SELECT note, color FROM colornotes WHERE id=? and deleted is null");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($note, $color);
		$stmt->execute();
		
		//tekitan objekti
		$n = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$n->note = $note;
			$n->color = $color;
			
			
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
	function updateNote($id, $note, $color){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["db"]);
		
		$stmt = $mysqli->prepare("UPDATE colornotes SET note=?, color=? WHERE id=? and deleted is null");
		$stmt->bind_param("ssi",$note, $color, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deleteNote($id){
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["db"]);
		
		$stmt = $mysqli->prepare("update colornotes set deleted=NOW() where id=? and deleted is null");
		$stmt->bind_param("i", $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "Your note was deleted.";
		} else {
		echo "Something went wrong";
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	
?>
