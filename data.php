<?php 
	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: lehekülguuendat.php");
		exit();
	}
	
	
	//kas kasutaja tahab välja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: lehekülguuendat.php");
		exit();
		
	}
	if (	isset($_POST["note"]) && 
			isset($_POST["color"]) && 
			!empty($_POST["note"]) && 
			!empty($_POST["color"]) 
	) {
		$note = cleanInput ($_POST["note"]);
		
		saveNote($note, $_POST["color"]);
		
	}
	
	$notes = getAllNotes();
	
?>

<h1>Data</h1>
<p syle="color: blue;">Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>



<h2>Sisesta mõned andmed</h2>



<form method="POST">

<label> Millist teenust pakkud? <label><br>
			<select>
				<option value= "torumees"> Torumees</option>
				<option value= "elektrik"> Elektrik</option>
				<option value= "koristaja"> Koristaja</option>
				<option value= "it-tugi"> IT-tugi</option>
			</select>
			
			<br><br>
<label> Millises linnaosas? <label><br>
			<select>
				<option value= "kristiine"> Kristiine</option>
				<option value= "viimsi"> Viimsi</option>
				<option value= "pirita"> Pirita</option>
				<option value= "lasnamäe"> Lasnamäe</option>
				<option value= "kesklinn"> Kesklinn</option>
				<option value= "pohja-tallinn"> Põhja-Tallinn</option>
				<option value= "mustamäe"> Mustamäe</option>
				<option value= "haabersti"> Haabersti</option>
				<option value= "nomme"> Nõmme</option>
				
			</select>
			
			<br><br>
			
    <label>Millistel kellaaegadel töötad?</label>
	<time datetime="2011-04-02">2nd</time> - <time datetime="2011-04-04">4th April 2011</time>
			
	<label>Märkus</label><br>
	<input name="note" type="text">
	
	<br><br>
	
	<label>Värv</label><br>
	<input name="color" type="color">
				
	<br><br>
	
	<input type="submit">
	

</form>

<h3>Arhiiv</h3>

<?php
 //iga liikme kohta masiivis
 
 foreach ($notes as $n) {
	 $style = "width:110px;
				min-height:90px;
				float: left;
				border: 1px solid gray;
				background-color: ".$n->noteColor.";";
	echo "<p style=' ".$style." '>".$n->note."</p>";
	
 }
 ?>
 <h2 style="clear:both">Tabel</h2>
 <?php
 
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
		
	
	foreach ($notes as $note) {
		$html .="<tr>";
		$html .="<td>" .$note ->id ."</td>";
		$html .="<td>" .$note ->note . "</td>";
		$html .="<td>".$note ->noteColor. "</td>";
		$html .="</tr>";
	}
	$html .= "</table>";
	echo $html;
	
	?>
	