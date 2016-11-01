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
		
		header("Location: minu lehekülg.php");
		exit();
		
	}
	//kontrollin kas on olemas profession ja location jms.
	if (	isset($_POST["profession"]) && 
			isset($_POST["location"]) && 
			isset($_POST["money"]) && 
			isset($_POST["color"]) &&
			isset($_POST["note"]) &&
			!empty($_POST["profession"]) && 
			!empty($_POST["location"]) && 
			!empty($_POST["money"]) && 
			!empty($_POST["color"])&& 
			!empty($_POST["note"])
			
	) {
		$note = cleanInput ($_POST["note"]);
		
		//muuda savenote fun
		saveNote($_POST["profession"], $_POST["location"], $_POST["money"], $_POST["color"], $_POST["note"] );
		
	}
	
	$notes = getAllNotes();
	
?>

<h1>Hei tragi töötegija. Oled jõudnud andmetelehele, kus aitame välja selgitada, millist abi pakud sina Eestile. </h1>

<ul>
  <li><a href="data.php">Kodu</a></li>
  <li><a href="user,php.php">Sina</a></li>
  <li><a href="minu lehekülg.php">Logi välja</a></li>
</ul>

<style type ="text/css">
	ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color:#00b3b3;
	}

	li {
    float: left;
	}

	li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
	}

	/* Change the link color to #111 (black) on hover */
	li a:hover {
    background-color: #111;
	}
	body {
		background-color:#003333;
	}
	h1{
		border-style: double;
		text-align: center;
		color:#00b3b3;
		font-size:45px;
		
	}
	h2{
		color:#00b3b3;
	}
</style>

<h2>Sisesta mõned andmed</h2>

<form method="POST">

<label> Millist teenust pakkud? <label><br>
			<select name="profession" >
				<option value= "plumber"> Torumees</option>
				<option value= "electrician"> Elektrik</option>
				<option value= "cleaner"> Koristaja</option>
				<option value= "it-support"> IT-tugi</option>
			</select>
			
			<br><br>
<label> Millises linnaosas? <label><br>
			<select name= "location">
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
			
			
	<label>Keskmine tunnitasu</label><br>
	<input type="range" name="money" min="0" max="15"  onchange="updateTextInput(this.value);">
	<input type="text" id="textInput" value="">
	<script>
		function updateTextInput(val) {
          document.getElementById('textInput').value=val; 
        }
	</script>
	
	<br><br>
	
	<label>Kirjelda ennast paari sõnaga:</label><br>
	<input name="note" type="text">
	
	<br><br>
	
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
	echo "<p style=' ".$style." '>".$n->note ."</p>";
	
 }
 ?>
 <h2 style="clear:both">Tabel</h2>
 <?php
 
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Teenus</th>";
			$html .= "<th>Linnaosa</th>";
			$html .= "<th>Eur/h</th>";
			$html .= "<th>Kirjeldus<th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
		
	
	foreach ($notes as $note) {
		$html .="<tr>";
		$html .="<td>".$note ->id."</td>";
		$html .="<td>".$note ->profession."</td>";
		$html .="<td>".$note ->location."</td>";
		$html .="<td>".$note ->money."</td>";
		$html .="<td>".$note ->note."</td>";
		$html .="<td>".$note ->noteColor."</td>";
		
		$html .="</tr>";
	}
	$html .= "</table>";
	echo $html;
	
	?>
	