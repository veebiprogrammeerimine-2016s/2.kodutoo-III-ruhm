<?php 
 class Note {
 	
     private $connection;
 	
 	function __construct($mysqli){
 		$this->connection = $mysqli;
 	}
 	
 	/* KLASSI FUNKTSIOONID */
     
     function saveNote($profession, $location, $money, $color, $note) {
 		
 		$stmt = $this->connection->prepare("INSERT INTO colornotes (profession, location, money, color, note) VALUES (?, ?, ?, ?, ?)");
 		echo $this->connection->error;
 		
 		$stmt->bind_param("ssiss", $profession, $location, $money, $color, $note );
 
 		if ( $stmt->execute() ) {
 			echo "salvestamine õnnestus";	
 		} else {	
 			echo "ERROR ".$stmt->error;
 		}
 		
	 }
		$stmt = $mysqli ->prepare(
		
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
 	
 	function getAllNotes($q, $sort, $order) {
 		
 		//lubatud tulbad
 		$allowedSort = ["id", "profession", "color", "location", "money", "note"];
 		
 		if(!in_array($sort, $allowedSort)){
 			//ei olnud lubatud tulpade sees
 			$sort = "id"; //las sorteerib id järgi
 		}
 		
 		$orderBy = "ASC";
 		
 		if($order == "DESC"){
 			$orderBy = "DESC";
 		}
 		
 		echo "sorteerin ".$sort." ".$orderBy." ";
 		
 		//otsime
 		if($q != "") {
 			
 			echo "Otsin: ".$q;
 			
 		$stmt = $this->connection->prepare("
			SELECT id, profession, location, note
			FROM colornotes
			WHERE deleted IS NULL
			AND (profession LIKE ?  OR location LIKE ? OR note LIKE ? )
 			ORDER BY $sort $orderBy
 			");
			
 		$searchWord = "%".$q."%";
 		$stmt->bind_param("sss", $searchWord, $searchWord, $searchWord);
 		
 		}else{
 			//ei otsi
 			$stmt = $this->connection->prepare("
 				SELECT id, profession, color, location, money, note
				FROM colornotes
				WHERE deleted IS NULL
 				ORDER BY $sort $orderBy
 			");
 		}
 		
 		$stmt->bind_result($id, $profession, $color, $location, $money, $note);
 		$stmt->execute();
 		
 		$result = array();
 		
 		// tsükkel töötab seni, kuni saab uue rea AB'i
 		// nii mitu korda palju SELECT lausega tuli
 		while ($stmt->fetch()) {
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
 	
 	function getSingleNoteData($edit_id){
    		
 		$stmt = $this->connection->prepare("SELECT profession, color, location, money, note FROM colorNotes WHERE id=? AND deleted IS NULL");
 
 		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($profession, $color, $location, $money, $note);
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
 		return $n;
 		
 	}
 
 
 	function updateNote($id, $color, $profession, $location, $money, $note){
 				
 		$stmt = $this->connection->prepare("UPDATE colornotes SET color=?, profession=?, location=?, money=?, note=? WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("sssisi", $color, $profession, $location, $money, $note, $id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		
 	}
 	
	
	
 	function deleteNote($id){
 		
 		$stmt = $this->connection->prepare("UPDATE colornotes 
		SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		
 		$stmt->bind_param("i", $id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 		echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		
 	}
 	
 } 
?> 