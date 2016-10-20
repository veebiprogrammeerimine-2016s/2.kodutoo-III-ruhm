<?php
require("functions.php");


//is the user meaning to log out?
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
	exit();
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


<!doctype html>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css"
</head> 
<style>
    body {
        font-family: Roboto;
        color: black;
    }
    h1 {
        padding: 0px;
        margin: 0px;
        font-weight: 200;
        color: white;
        background-color: DarkSlateGray;
        font-size: 300%;
        text-align:center;
    }
    h2 {
        margin-top: 4px;
        margin-bottom: 4px;
        font-weight: 300;
        color: White;
        background-color: DarkSlateGray;
        padding: 4px;
        text-align:center;
        font-size: 180%
    }
    legend {
        color: DarkSlateGray;
        font-weight: 500;
    }
    header, footer {
        color: white;
        background-color: DarkSlateGray;
        text-decoration: none;
        clear: left;
        text-align: center;
    }
</style>
<head><title>My extra-mega-secure website, yo</title></head>



<h1 style="clear:both;">Welcome, <?=$_SESSION["userEmail"]?>.</h1>

<style>
    ul {
        list-style-type: none;
        margin: 0px;
        padding: 0px;
        overflow: hidden;
        background-color: DarkSlateGray;
        }
    li {
        float: left;}
    a {
        display: block;
        padding: 8px
    }
    li a {
        display: block;
        padding: 8px;
        color: White;
        background-color: DarkSlateGray;
        text-decoration: none}
    li a:hover {
        background-color: DarkSlateBlue}
    li a:active {
        background-color: DimGray}
    .active {
    background-color: DarkSeaGreen;}
</style>
<ul>
    
    <li><a class="active" href="data.php">Home</a></li>
    <li><a href="user.php">User</a></li>
    <li><a href="options.php">Options</a></li>
    <li style="float: right"><a href="?logout=1">Log out</a></li>
</ul>

	<h2 style="margin-top: 0px;">Enter some notes!</h2>
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
	$style = "width:150px; margin: 7px; padding:4px; float:left; min-height:150px; border:1px solid gray; word-wrap: break-word;background-color: ".$n->notecolor.";";
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

<footer>
<p style="font-family:'Roboto'; padding: 8px">Mihkel's random website | 2016</p>
</footer>
