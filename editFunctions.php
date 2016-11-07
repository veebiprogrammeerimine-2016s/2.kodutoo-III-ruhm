<?php
	require_once("../../../config.php");

	$database = "if16_elleivan";

	//ei ole sisseloginud, suunan login lehele
		if(!isset ($_SESSION["userId"])) {
			header("Location: signup.php");
			exit();
		}

	function getSingleNoteData($edit_id){

		//echo "id on ".$edit_id;

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT note, color, r100, r50, r20, r10, r5, r2, r1 FROM colorNotes WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($note, $color, $r100, $r50, $r20, $r10, $r5, $r2, $r1);
		$stmt->execute();

		//tekitan objekti
		$n = new Stdclass();

		//saime ühe rea andmeid
		if($stmt->fetch()){
			//sain siis alles kasutada bind_result muutujaid
			$n->note = $note;
			$n->color = $color;
			$n->r100 = $r100;
			$n->r50 = $r50;
			$n->r20 = $r20;
			$n->r10 = $r10;
			$n->r5 = $r5;
			$n->r2 = $r2;
			$n->r1 = $r1;

		}else{
			//ei saanud rida andmeid kätte
			//sellist id'd ei ole olemas
			//see rida võib olla kustutatud
			header("Location: data.php");
			exit();

		}

		$stmt->close();
		$mysqli->close();

		return $n;
	}

	function updateNote($id, $note, $color, $r100, $r50, $r20, $r10, $r5, $r2, $r1) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("UPDATE colorNotes SET note=?, color=?, r100=?, r50=?, r20=?, r10=?, r5=?, r2=?, r1=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("ssiiiiiii", $note, $color, $r100, $r50, $r20, $r10, $r5, $r2, $r1);

		//kas õnnestus salvestada
		if($stmt->execute()){
			//õnnestus
			echo "salvestus õnnestus!";
			header ("Location: data.php");
		}

		$stmt->close();
		$mysqli->close();

	}

	function deleteNote($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("UPDATE colorNotes SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);

		//kas õnnestus salvestada
		if($stmt->execute()){
			//õnnestus
			echo "salvestus õnnestus!";
		}

		$stmt->close();
		$mysqli->close();
	}
?>