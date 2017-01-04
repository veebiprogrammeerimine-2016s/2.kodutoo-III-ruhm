<?php
 	//edit.php
 	require("functions.php");
 	require("editFunctions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas aadressireal on delete
	if (isset($_GET["delete"])){
		// saadan kaasa aadressirealt id
		deleteNote($_GET ["id"]);
		header ("Location: data.php");
		exit();
	}
	
	
 	//kas kasutaja uuendab andmeid
 	if(isset($_POST["update"])){
 		
 		updateNote(cleanInput($_POST["id"]),($_POST["color"]), cleanInput($_POST["profession"]), cleanInput($_POST["location"]),
		cleanInput ($_POST["money"]), cleanInput ($_POST["note"]));
 		
 		header("Location: edit.php?id=".$_POST["id"]."&success=true");
    exit();	
		 
 		
 	}
 	
 	//saadan kaasa id
 	$c = getSingleNoteData($_GET["id"]);
 	//var_dump($c);
 
 	
 ?>
 
 <link rel="stylesheet" href="Style/data.css">
 <ul>
  <li><a href="data.php">Kodu</a></li>
 </ul>
<body>
 <h2>Muuda kirjet</h2>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
	<label for="profession" > Millist teenust pakud?</label><br>
	<select name="profession" >
			<?php if ($profession == "plumber") { ?>
			<option value= "plumber" selected> Torumees</option>
			<?php } else { ?>
			<option value= "plumber"> Torumees</option>
			<?php } ?>
			<?php if ($profession == "electrician") { ?>
			<option value= "electrician"selected> Elektrik</option>
			<?php } else { ?>
			<option value= "electrician"> Elektrik</option>
			<?php }  ?>
			<?php if ($profession == "cleaner") { ?>
			<option value= "cleaner"selected> Koristaja</option>
			<?php } else { ?>
			<option value= "cleaner"> Koristaja</option>
			<?php }  ?>
			<?php if ($profession == "it-support") { ?>
			<option value= "it-support" selected> IT-tugi</option>
			<?php } else { ?>
			<option value= "it-support"> IT-tugi</option>
			<?php }  ?>
	</select>
		<br><br>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
	<label for="location" > Millises linnaosas?</label><br>
	<select name="location" >
			<?php if ($location == "kristiine") { ?>
			<option value= "kristiine" selected>Kristiine</option>
			<?php } else { ?>
			<option value= "kristiine">Kristiine</option>
			<?php } ?>
			<?php if ($location == "viimsi") { ?>
			<option value= "viimsi"selected>Viimsi</option>
			<?php } else { ?>
			<option value= "viimsi">Viimsi</option>
			<?php }  ?>
			<?php if ($location == "pirita") { ?>
			<option value= "pirita"selected>Pirita</option>
			<?php } else { ?>
			<option value= "pirita">Pirita</option>
			<?php }  ?>
			<?php if ($location == "lasnamäe") { ?>
			<option value= "lasnamäe" selected>Lasnam2e</option>
			<?php } else { ?>
			<option value= "lasnamäe">Lasnam2e</option>
			<?php }  ?>
			<?php if ($location == "kesklinn") { ?>
			<option value= "kesklinn" selected>Kesklinn</option>
			<?php } else { ?>
			<option value= "kesklinn">Kesklinn</option>
			<?php }  ?>
			<?php if ($location == "pohja-tallinn") { ?>
			<option value= "pohja-tallinn" selected>Põhja-Tallinn</option>
			<?php } else { ?>
			<option value= "pohja-tallinn">Põhja-Tallinn</option>
			<?php }  ?>
			<?php if ($location == "mustamäe") { ?>
			<option value= "mustamäe" selected>Mustamäe</option>
			<?php } else { ?>
			<option value= "mustamäe">Mustamäe</option>
			<?php }  ?>
			<?php if ($location == "haabersti") { ?>
			<option value= "haabersti" selected>Haabersti</option>
			<?php } else { ?>
			<option value= "haabersti">Haabersti</option>
			<?php }  ?>
			<?php if ($location == "nomme") { ?>
			<option value= "nomme" selected>Nõmme</option>
			<?php } else { ?>
			<option value= "nomme">Nõmme</option>
			<?php }  ?>
	</select>
	<br><br>
	<label>Keskmine tunnitasu</label><br>
	<input type="range" name="money" min="0" max="15" onchange="updateTextInput(this.value);">
	<input type="text" id="textInput" value="<?=$c->money;?>">
	<script>
		function updateTextInput(val) {
          document.getElementById('textInput').value=val; 
        }
	</script>
		<br><br>	
   	<label for="note" >Kirjeldus</label><br>
 	<textarea  id="note" name="note"><?php echo $c->note;?></textarea><br>
	<br><br>
   	<label for="color" >V2rv</label><br>
 	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
   	
 	<input type="submit" name="update" value="Salvesta">
   </form> 
   
<br>
<br>
<a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>
</body>