<?php
require("../functions.php");
require("../class/Note.class.php");
require("../class/Helper.class.php");
$Note = new Note($mysqli);
$Helper = new Helper();
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
		$note = $Helper->cleanInput($note);
		$color = $Helper->cleanInput($color);
		$Note->save($note, $color);
	}
}

    $q="";
    if(isset($_GET["q"])) {
        $q = $Helper->cleanInput($_GET["q"]);
    }
$orderId = "ASC";
$sort = "id";
if(isset($_GET["sort"]) && isset($_GET["order"])) {
    $sort = $_GET["sort"];
    $orderId = $_GET["order"];
}
$notes = $Note->getAll($q, $sort, $orderId);
echo "<pre>";
//var_dump($notes);
echo "</pre>";
?>


<?php require("../header.php"); ?>

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
	<button class="button" type="submit">Save your note</button>
	</form>
	</fieldset>
<?php

foreach ($notes as $n) {
	$style = "width:150px; margin: 7px; padding:4px; float:left; min-height:150px; border:1px solid gray; word-wrap: break-word;background-color: ".$n->notecolor.";";
	echo "<p style='".$style."'>".$n->note."</p>";
}
?>

<h2 style="clear:both;">Table</h2>
<form>
    <input type="search" name="q" value="<?=$q;?>">
    <!--<input type="submit" value="Search">-->
    <button class="button" type="submit">Search</button>
</form>
<?php


if (isset($_GET["order"]) && $_GET["order"] == "ASC" && $_GET["sort"] = "id"){
    $orderId = "DESC";
}
if (isset($_GET["order"]) && $_GET["order"] == "ASC" && $_GET["sort"] = "note"){
    $orderId = "DESC";
}
if (isset($_GET["order"]) && $_GET["order"] == "ASC" && $_GET["sort"] = "color"){
    $orderId = "DESC";
}

	$html = "<table class='table table-hover table-striped table-condensed'>";
	$html .= "<tr>";
		$html .= "<th><a href='?q=".$q."&sort=id&order=".$orderId."'>id</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=note&order=".$orderId."'>Note</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=color&order=".$orderId."'>Color</a></th>";
	$html .= "</tr>";

	foreach ($notes as $note) {
		$html .= "<tr>";
		$html .= "<td>".$note->id."</td>";
		$html .= "<td>".$note->note."</td>";
		$html .= "<td>".$note->notecolor."</td>";
		$html .= "<td><a href='edit.php?id=".$note->id."'><span class='glyphicon glyphicon-pencil'></a></td>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;
?>


<?php require("../footer.php"); ?>
