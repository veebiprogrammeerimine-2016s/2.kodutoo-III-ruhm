<?php 
 	
 	require("functions.php");
 	
 	//kui ei ole kasutaja id'd
 	if (!isset($_SESSION["userId"])){
 		
 		//suunan sisselogimise lehele
 		header("Location: login.php");
 		exit();
 	}
 	
 	
 	//kui on ?logout aadressireal siis login välja
 	if (isset($_GET["logout"])) {
 		
 		session_destroy();
 		header("Location: login.php");
 		exit();
 	}
 	
 	$msg = "";
 	if(isset($_SESSION["message"])){
 		$msg = $_SESSION["message"];
 		
 		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
 		unset($_SESSION["message"]);
 	}
 	
 	
 	if ( isset($_POST["interest"]) && 
 		!empty($_POST["interest"])
 	  ) {
 		  
 		saveInterest(cleanInput($_POST["interest"]));
 		
 	}
 	
     $interests = getAllInterests();
 	
 ?>
 <link rel="stylesheet" href="Style/data.css">
 <div class="flex-container">
<header>
  <h1 style="clear:both;">Hei, <?=$_SESSION["userEmail"]?>. Siin lehel saame sinust rohkem teada! </h1>
</header>
 
 <ul>
  <li><a href="user,php.php">Oled siin</a></li>
  <li><a href="data.php">Kodu</a></li>
  <li><a href="minu lehekülg.php">Logi välja</a></li>
</ul>
 
 <?php
     
     $listHtml = "<ul>";
 	
 	foreach($interests as $i){
 		
 		
 		$listHtml .= "<li>".$i->interest."</li>";
 
 	}
     
     $listHtml .= "</ul>";
 
 	
 	echo $listHtml;
     
?>
 <h2>Salvesta hobi</h2>
 <form method="POST">
 	<label>Hobi/huviala nimi</label><br>
 	<input name="interest" type="text">
 	<input type="submit" value="Salvesta">	
 </form>
 
 
 <h2>Võid valida ka olemasolevate hulgast:</h2>
 <form method="POST">
 	
 	<label>Hobi/huviala nimi</label><br>
 	<select name="userInterest" type="text">
         <?php
             
             $listHtml = "";
         	
         	foreach($interests as $i){
         		
         		
         		$listHtml .= "<option value='".$i->id."'>".$i->interest."</option>";
         
         	}
         	
         	echo $listHtml;
             
         ?>
     </select>
     	
 	
 	<input type="submit" value="Lisa">
 	
 </form> 