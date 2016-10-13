<?php
require("functions.php");


//is the user meaning to log out?
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
}

if (!isset($_SESSION["userId"])) {
header("Location: login.php");
exit();
}

if (isset($_POST["note"]) and isset($_POST["notecolor"])) {
	if (!empty($_POST["note"]) and !empty($_POST["notecolor"])) {
		$note = $_POST["note"];
		$color = $_POST["notecolor"];
		$note = cleanInput($note);
		$color = cleanInput($color);
		saveNote($note, $color);
	}
}
$notes = getAllNotes();
echo "<pre>";
//var_dump($notes);
echo "</pre>";
?>



<h1>Data</h1>
<p>Welcome, <?=$_SESSION["userEmail"]?>.
<a href="?logout=1">Log out</a>
</p>
	<h1>Enter some notes!</h1>
	<fieldset>
	<legend>Enter notes!</legend>
	<form method="POST">
	<label>Note</label>	
	<br>
	<textarea name="note" type="text" autofocus rows="4" cols="50"></textarea>
	<br><br> 
	<label>Note color</label>
	<br>
	<input name="notecolor" type="color">
	<br><br>
	<input type="submit" value="Save your note">
	</form>
	</fieldset>
<?php

foreach ($notes as $n) {
	$style = "width:150px; float:left;min-height:150px; border:1px solid gray; background-color: ".$n->notecolor.";";
	echo "<p style='".$style."'>".$n->note."</p>";
}
?>

<h2 style="clear:both;">Tabel</h2>
<?php

	$html = "<table>";
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>Note</th>";
		$html .= "<th>Color</th>";
	$html .= "</tr>";

	foreach ($notes as $note) {
		$html .= "<tr>";
		$html .= "<td>".$note->id."</td>";
		$html .= "<td>".$note->note."</td>";
		$html .= "<td>".$note->notecolor."</td>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;
?>
