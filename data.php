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
	
	
	
	if (	isset($_POST["kaamera"]) && 
			isset($_POST["hind"]) && 
			isset($_POST["seisukord"]) && 
			!empty($_POST["kaamera"]) && 
			!empty($_POST["hind"]) &&
			!empty($_POST["seisukord"]) 
	) {
		
		$note = cleanInput($_POST["kaamera"]);
		
		//Enam ei saa naiteks KickAssi scriptina jooksutada
		
		saveInfo($_POST["kaamera"], $_POST["hind"], $_POST["seisukord"]);
		
	}
	
	
	$notes = getAllNotes();
	
	//echo "<pre>";
	//var_dump($notes);
	//echo "</pre>";
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>



<h2>Kaamerate ost/müük/vahetus</h2>
		<form method="POST">
			
			<label>Kaamera</label><br>
			<input name="kaamera" type="text">
			
			<br><br>
			
			<label>Hind</label><br>
			<input name="hind" type="text">
			
			<br><br>
			
			<label>Seisukord</label><br>
			<input name="seisukord" type="text">
			
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
			$html .= "<th>Kaamera</th>";
			$html .= "<th>Hind</th>";
			$html .= "<th>Seisukord</th>";
		$html .="</tr>";
		
		
		
		
	
	foreach ($notes as $note) {
			
		$html .= "<tr>";
			$html .= "<td>".$note->id."</th>";
			$html .= "<td>".$note->kaamera."</th>";
			$html .= "<td>".$note->hind."</th>";
			$html .= "<td>".$note->seisukord."</th>";
			
		$html .="</tr>";
		
	}
	
	$html .="</table>";

	echo $html;


?>