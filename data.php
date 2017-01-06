<?php
	//eet saada ligi sessioonile.
	require ("functions.php");
	//kui pole sisse loginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
		
	}
		
	
	//kas kasutaja tahab välja logida
	//kas aaddressi real on logout olemas
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}

	if( isset ($_POST["note"]) &&
		isset ($_POST["color"]) &&
		!empty ($_POST["note"]) &&
		!empty ($_POST["color"])
	) {
		$note = cleanInput($_POST["note"]);
		saveNote($note, $_POST["color"]);
		
	}
	$notes = getAllNotes();
	echo "<pre>";
	var_dump($notes);
	echo "</pre>";
	
	$Märge = "";
	$emptyMärge = "";
	
	if (isset ($_POST["Märge"])) {
		if (empty ($_POST["Märge"])) {
			$emptyMärge = "See peab olema täidetud, nagu su ema!";
		} else {
			$Märge = $_POST["Märge"];
	}
}
	
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>
	<a href="?logout=1">Logi välja</a>
</p>

<form method="POST">

<h2>Märkused</h2>
			

			<label>Märge</label><br>
			<input name="note" type="text" value="<?=$Märge;?>"> <?php echo $emptyMärge; ?>		
			
			<br><br>
			
			<label>Värv</label><br>
			<input name="color" type="color">
						
			<br><br>
			
			<input type="submit">
			
		</form>

<?php
	//iga liikme kohta massiivis
	
	foreach($notes as $n) {
		//$style = "width:100px; min-height:100px; border:1px solid gray; background-color: ".$n->noteColor.";";
		
		//echo "<p style=' ".$style." '>".$n->note."</p>";
		
		
	}
?>

	<h2 style="clear:both;">Tabel</h2>
<?php
	
	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
		
	foreach ($notes as $note) {
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
		$html .= "</tr>";
		
		
	}

	$html .= "</table>";
	echo $html;





