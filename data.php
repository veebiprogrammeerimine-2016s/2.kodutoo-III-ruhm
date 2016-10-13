 <?php

	//et saada ligi sessioonile
	require("functions.php");
	
	//ei ole
	if(!isset($_SESSION["userId"])) {
		header("Location: login1.php");
		exit();
	}

	//kas kasutaja tahab välja logida
	//kas aadressil on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login1.php");
		exit();
	}
	if (	isset($_POST["firstname"]) &&
			isset($_POST["lastname"]) &&
			isset($_POST["notebook"]) &&
			isset($_POST["serialnumber"]) &&
			isset($_POST["priority"]) &&
			isset($_POST["note"]) &&
			isset($_POST["color"]) &&
			isset($_POST["comment"]) &&
			
			!empty($_POST["firstname"]) &&
			!empty($_POST["lastname"]) &&
			!empty($_POST["notebook"]) &&
			!empty($_POST["serialnumber"]) &&
			!empty($_POST["priority"]) &&
			!empty($_POST["note"]) &&
			!empty($_POST["color"]) &&
			!empty($_POST["comment"]) 
			
	) {
			var_dump($_POST);

		saveNote($_POST["firstname"],$_POST["lastname"],$_POST["notebook"],$_POST["serialnumber"],
				 $_POST["priority"],$_POST["note"],$_POST["color"],$_POST["comment"]);
	}
	
	$notes = getAllNotes();
	
	//echo "<pre>";
	//var_dump($notes[0]);
	//echo "</pre>";
	
?>


		<h1>DATA</h1>

	<p>
		Tere tulemast <?=$_SESSION["userEmail"];?>!
		<br><br>
		<a href="?logout=1">Logi välja</a> 
		

	<p>
	
<html>

	<body>
	<form method="POST">
		<h2>Arvuti registreerimine remondiks</h2>
			
			<br>
			
			<label><b>Nimi<b></label>
			 <br><input name="firstname" type="text"> 
			
			<br><br>
			

			<label><b>Perekonnanimi</b></label>
			 <br><input name="lastname" type="text">
			
			<br><br>
			
			<label><b>Arvuti</b></label>
			
			<br><br>
			
			<select name="notebook">
				<option value="asus">Asus</option>
				<option value="dell">Dell</option>
				<option value="lenovo">Lenovo</option>
			</select>
			
			<br><br>
			
			<label><b>Seerianumber</b></label>
			 <br><input name="serialnumber" type="text">
			
			<br><br>
			
			<label><b>Prioriteet</b></label>
			
			<br><br>
			
			<select name="priority">
				<option value="high">Kõrge</option>
				<option value="normal">Normaalne</option>
				<option value="low">Madal</option>
			</select>
			
			<br><br>
			
			<label>Märkmed</label><br>
			<input name="note" type="text">
			
			<br><br>
			
			
			<label>Värv</label><br>
			<input name="color" type="color">
						
			<br><br>
			
			<h3>Veakirjeldus</h3>
			
			
			
			<textarea name="comment" rows="5" cols="40"> </textarea>
			
			<br> <br>
			
			<input type="submit">
		
</form>
			


<?php


	//iga liigi kohta masiivis
	
	//foreach($notes as $n) {
		
		//$style = "width:200px;
				 // min-height:200px; x
				  //border: 1px solid gray;
				  //background-color: " .$n->noteColor.";";
				 
			//echo "<p style ='  ".$style."  '>".$n->note."</p>";
		
	//}



?>
	
<h2 style="clear:both;">Tabel</h2>
<?php

	$html = "<table>";
		
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Firstname</th>";
			$html .= "<th>Lastname</th>";
			$html .= "<th>Notebook</th>";
			$html .= "<th>Serialnumber</th>";
			$html .="<th>Priority</th>";
			$html .= "<th>Notes</th>";
			$html .= "<th>Color</th>";
			$html .= "<th>Comment</th>";
		$html .= "</tr>";	
			
	foreach($notes as $note) {
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->firstname."</td>";
			$html .= "<td>".$note->lastname."</td>";
			$html .= "<td>".$note->notebook."</td>";
			$html .= "<td>".$note->serialnumber."</td>";
			$html .= "<td>".$note->priority."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
			$html .= "<td>".$note->comment."</td>";
		$html .= "</tr>";		
		
	}
	$html .= "</table>";
	
	echo $html;
?>	