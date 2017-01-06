

<?php

	//Ühendan sessiooniga
	require("../../config.php");
	require("functions.php");

	
	//$database = "database";
	//$mysqli = new mysqli($servername, $username, $password, $database);
	//Kui ei ole sisse loginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_POST["description"]) && 
	isset($_POST["location"]) &&
	isset($_POST["date"]) &&
	isset($_POST["url"]) &&
	!empty($_POST["description"]) &&
	!empty($_POST["location"]) &&
	!empty($_POST["date"])&& 
	!empty($_POST["url"]))	{
		tabelisse2($_POST["description"], $_POST["location"], $_POST["date"],$_POST["url"]);
	}
	
	$nature2 = getAllNature();
	
	/*
	echo "<pre>";
	var_dump ($people);
	echo "</pre>";
	*/
	
?>
<h1>Data</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>
	<a href="?logout=1">Logi välja</a>
</p>
<br>

<form method="POST">
	<input name="description" placeholder="Kirjeldus" type="text"> <br><br>
	<input name="location" placeholder="Asukoht" type="text"> <br><br>
	<input name="date" placeholder="Kuupäev" type="text"> <br><br>
	<input name="url" placeholder="Pilt" type="text"> <br><br>
	<input type="submit" value="Sisesta andmed">
</form>

<h2>Arhiiv</h2>

<?php

	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>ID</th>";
		$html .= "<th>Pilt</th>";
		$html .= "<th>Kirjeldus</th>";
		$html .= "<th>Asukoht</th>";
		$html .= "<th>Kuupäev</th>";
	$html .= "</tr>";

	//iga liikme kohta massiivis
	foreach ($nature2 as $n) {
		$html .= "<tr>";
			$html .= "<td>".$n->id."</td>";
			$html .= "<td><img width='150' src=' ".$n->url." '></td>";
			$html .= "<td>".$n->description."</td>";
			$html .= "<td>".$n->location."</td>";
			$html .= "<td>".$n->day."</td>";
			
			$html .= "</tr>";
		
	}
	$html .= "</table>";
	echo $html;
?>


<?php
	/*
	foreach($people as $p){
		
		$style = "
		
			background-color:".$p->lightColor.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 20px;
		
		";
		
		echo "<p style='".$style."'>".$p->age."</p>";
		
	}
	*/
?>















