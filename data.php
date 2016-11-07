<?php
	//et saada ligi sessioonile
	require("functions.php");

	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: signup.php");
		exit();

	}


	//kas kasutaja tahab välja logida
	//kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {

		session_destroy();

		header("Location: signup.php");
		exit();

	}
if (isset($_POST["note"]) &&
	isset($_POST["color"]) &&
	isset($_POST["r100"]) &&
	isset($_POST["r50"]) &&
	isset($_POST["r20"]) &&
	isset($_POST["r10"]) &&
	isset($_POST["r5"]) &&
	isset($_POST["r2"]) &&
	isset($_POST["r1"]) &&
	!empty($_POST["note"]) &&
	!empty($_POST["color"]) &&
	!empty($_POST["r100"]) &&
	!empty($_POST["r50"]) &&
	!empty($_POST["r20"]) &&
	!empty($_POST["r10"]) &&
	!empty($_POST["r5"]) &&
	!empty($_POST["r2"]) &&
	!empty($_POST["r1"])
	) {

		$note = cleaninput($_POST["note"]);

		saveNote($_POST["note"], $_POST["color"], $_POST["r100"], $_POST["r50"], $_POST["r20"], $_POST["r10"], $_POST["r5"], $_POST["r2"], $_POST["r1"]);
	}
	$notes = getAllNotes();
	echo "<pre>";
	//var_dump($notes);
	echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
<style>
p.monospace {
	font-family: "Courier New", Courier, monospace;";
}
</style>
</head>
<body>

<h1 style="text-align:center; font-family:'Courier New', Courier, monospace;">Aruanne</h1>
	<p style="text-align: right;" class="monospace">Tere tulemast <a href="user.php"><?=$_SESSION["userUsername"];?></a>!
	<br>
	<a href="?logout=1">Logi välja</a>
	<br>
	</p>



<form method="POST">

	<label>Kuupäev</label><br>
	<input name="date" type="date">

	<br><br>
	
	<h3 style="font-family:'Courier New', Courier, monospace;">Sularaha</h3>		

	<p><i>Kui rahatäht puudub, sisesta "0".</i></p><br>

	<label>100</label><br>
	<input name="r100" type="text">
	
	<br><br>
			
	<label>50</label><br>
	<input name="r50" type="text">	
			
	<br><br>

	<label>20</label><br>
	<input name="r20" type="text">	
			
	<br><br>
	
	<label>10</label><br>
	<input name="r10" type="text">	
			
	<br><br>

	<label>5</label><br>
	<input name="r5" type="text">	
			
	<br><br>

	<label>2</label><br>
	<input name="r2" type="text">	
			
	<br><br>

	<label>1</label><br>
	<input name="r1" type="text">	
			
	<br><br>	

	<label>Märkmed</label><br>
	<textarea name="note" rows="5" cols="25"></textarea>
	
	<br><br>

	<label>Vali värv</label><br>			
	<input name="color" type="color">

	<br><br>

	<input type="submit" value="Salvesta">
			
		
</form>

<h2 style="text-align:center; font-family:'Courier New', Courier, monospace;">Arhiiv</h2>

<?php

	//iga liikme kohta massiiviks
foreach ($notes as $n) {

	$style = "width:200px; float:left; min-height:100px; border:1px solid gray; background-color: ".$n->noteColor.";";

	echo "<p style=' ".$style." '>".$n->note."</p>";

}

?>

<h2 style="text-align:left; font-family:'Courier New', Courier, monospace;">Tabel</h2>
<?php

	$html = "<table>";

		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
			$html .= "<th>100</th>";
			$html .= "<th>50</th>";
			$html .= "<th>20</th>";
			$html .= "<th>10</th>";
			$html .= "<th>5</th>";
			$html .= "<th>2</th>";
			$html .= "<th>1</th>";
		$html .= "</tr>";

	foreach ($notes as $note) {
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
			$html .= "<td>".$note->r100."</td>";
			$html .= "<td>".$note->r50."</td>";
			$html .= "<td>".$note->r20."</td>";
			$html .= "<td>".$note->r10."</td>";
			$html .= "<td>".$note->r5."</td>";
			$html .= "<td>".$note->r2."</td>";
			$html .= "<td>".$note->r1."</td>";
			$html .= "<td><a href='edit.php?id=".$note->id."'>edit.php</a></td>";
		$html .= "</tr>";
	}

	$html .= "</table>";

	echo $html;


?>