<?php
require("../functions.php");
require("../editfunctions.php");
require("../class/Note.class.php");
require("../class/Helper.class.php");
$Note = new Note($mysqli);
$Helper = new Helper();



    if(isset($_GET["delete"])){
       deleteNote($_GET["id"]);
        header("Location: data.php");
        exit;
    }
    
    
	if(isset($_POST["update"])){
		
		updateNote($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["note"]), $Helper->cleanInput($_POST["color"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}

$c = getSingleNoteData($_GET["id"]);
var_dump($c);
?>

<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../mystyle.css">
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
    <li style="float: right"><a href="?logout=1">Log out</a></li>
</ul>

<h2>Change the entry</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
        <label for="note">Note text</label><br>
        <textarea id="note" name="note"><?php echo $c->note;?></textarea><br>
        <label for="color">Color of the note</label><br>
        <input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
        <button class="button" type="submit" name="update">Update</button>
        <a href="?id=<?=$_GET["id"];?>&delete=true">Delete note</a>
        
    </form>

</html>
