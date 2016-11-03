<?php
 	//edit.php
 	require("functions.php");
 	require("editFunctions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: minu lehekülg.php");
		exit();
	}
 	
 	//kas kasutaja uuendab andmeid
 	if(isset($_POST["update"])){
 		
 		updateNote(cleanInput($_POST["color"]), cleanInput($_POST["profession"]), cleanInput($_POST["location"]), cleanInput ($_POST["money"]), cleanInput ($_POST["note"]));
 		
 		header("Location: edit.php?id=".$_POST["id"]."&success=true");
         exit();	
		 
 		
 	}
 	
 	//saadan kaasa id
 	$c = getSingleNoteData($_GET["id"]);
 	var_dump($c);
 
 	
 ?>
 <ul>
  <li><a href="data.php">Kodu</a></li>
 </ul>
 
 <h2>Muuda kirjet</h2>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
   	<label for="note" >Kirjeldus</label><br>
 	<textarea  id="note" name="note"><?php echo $c->note;?></textarea><br>
   	<label for="color" >Värv</label><br>
 	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
   	
 	<input type="submit" name="update" value="Salvesta">
   </form> 
   
 
<br>
<br>
<a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>