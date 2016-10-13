<?php 
	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	
	//kas kasutaja tahab välja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	
	
	if (	isset($_POST["note"]) && 
			isset($_POST["color"]) && 
			!empty($_POST["note"]) && 
			!empty($_POST["color"]) 
	) {
		
		$note = cleanInput($_POST["note"]);
		
		//Enam ei saa naiteks KickAssi scriptina jooksutada
		
		saveNote($_POST["note"], $_POST["color"]);
		
	}
	
	
	$notes = getAllNotes();
	
	echo "<pre>";
	var_dump($notes);
	echo "</pre>";
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>



<h2>Märkmed</h2>
		<form method="POST">
			
			<label>Märkus</label><br>
			<input name="note" type="text">
			
			<br><br>
			
			<label>Värv</label><br>
			<input name="color" type="color">
						
			<br><br>
			
			<input type="submit">
		
		</form>
		
		

<?php

	//iga liikme kohta massiivis
	foreach ($notes as $n) {
		
		//$style = "width:100px; min-height:100px; border: 1px solid gray; background-color: ".$n->noteColor.";";
		
		
		//echo "<p style=' ".$style."  '>".$n->note."</p>";
	}




?>		

<h2 style="clear:both;">Tabel</h2>
<?php


	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
		$html .="</tr>";
		
		
		
		
	
	foreach ($notes as $note) {
			
		$html .= "<tr>";
			$html .= "<td>".$note->id."</th>";
			$html .= "<td>".$note->note."</th>";
			$html .= "<td>".$note->noteColor."</th>";
			
		$html .="</tr>";
		
	}
	
	$html .="</table>";

	echo $html;


?>