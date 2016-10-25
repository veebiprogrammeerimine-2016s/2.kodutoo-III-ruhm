 <?php

	//et saada ligi sessioonile
	require("functions.php");
	
	//ei ole
	if(!isset($_SESSION["userId"])) {
		header("Location: login1.php");
		exit();
	}

	//kas kasutaja tahab välja logida
	//kas aadressil on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login1.php");
		exit();
	}
	if (	isset($_POST["firstname"]) &&
			isset($_POST["lastname"]) &&
			isset($_POST["notebook"]) &&
			isset($_POST["serialnumber"]) &&
			isset($_POST["priority"]) &&
			isset($_POST["note"]) &&
			isset($_POST["color"]) &&
			isset($_POST["comment"]) &&
			
			!empty($_POST["firstname"]) &&
			!empty($_POST["lastname"]) &&
			!empty($_POST["notebook"]) &&
			!empty($_POST["serialnumber"]) &&
			!empty($_POST["priority"]) &&
			!empty($_POST["note"]) &&
			!empty($_POST["color"]) &&
			!empty($_POST["comment"]) 
			
	) {
	
		$_POST["firstname"] = cleanInput($_POST["firstname"]);
		$_POST["lastname"] = cleanInput($_POST["lastname"]);
		$_POST["serialnumber"] = cleanInput($_POST["serialnumber"]);
		$_POST["note"] = cleanInput($_POST["note"]);
		$_POST["comment"] = cleanInput($_POST["comment"]);
		
		saveNote($_POST["firstname"],$_POST["lastname"],$_POST["notebook"],$_POST["serialnumber"],
				 $_POST["priority"],$_POST["note"],$_POST["color"],$_POST["comment"]);
	}
	
	$notes = getAllNotes();
	
	//echo "<pre>";
	//var_dump($notes[0]);
	//echo "</pre>";
	
	
	
	$firstnameError = "";
	$firstname = "";
	
	//kas on üldse olemas
	if (isset ($_POST["firstname"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli tühi
		if (empty ($_POST["firstname"])) {
			
			//oli tõesti tühi
			$firstnameError = "Enter your name!";
			
		} else {
				
			// kõik korras, nimi ei ole tühi ja on olemas
			$firstname = $_POST["firstname"];
		}
		
	}	
	
	$lastnameError = "";
	$lastname = "";
	
	if (isset ($_POST["lastname"])) {
		
		if (empty ($_POST["lastname"])) {
			
			$lastnameError = "Enter your lastname!";
			
		} else {
				
			$lastname = $_POST["lastname"];
		}
		
	}	
	
	$serialnumberError = "";
	$serialnumber = "";
	
	if (isset ($_POST["serialnumber"])) {
		
		
		if (empty ($_POST["serialnumber"])) {
			
				$serialnumberError = "Enter the serialnumber!";
			
		} else {
				
			$serialnumber = $_POST["serialnumber"];
		}
		
	}	
	
?>


		<h1>Repair registration</h1>

	<p>
		Welcome, <?=$_SESSION["userEmail"];?>!
		<br><br>
		<a href="?logout=1">Logout</a> 
		

	<p>
	
<html>

	<body>
	<form method="POST">
		<h2>Enter the information:</h2>
			
			<br>
			
			<label><b>Name<b></label>
			 <br><input name="firstname" type="text" value="<?=$firstname;?>" > <?php echo $firstnameError; ?>
			
			<br><br>
			

			<label><b>Lastname</b></label>
			 <br><input name="lastname" type="text" value="<?=$lastname;?>" > <?php echo $lastnameError; ?>
			
			<br><br>
			
			<label><b>PC</b></label>
			
			<br><br>
			
			<select name="notebook">
				<option value="asus">Asus</option>
				<option value="dell">Dell</option>
				<option value="lenovo">Lenovo</option>
			</select>
			
			<br><br>
			
			<label><b>Serialnumber</b></label>
			 <br><input name="serialnumber" type="text" value="<?=$serialnumber;?>" > <?php echo $serialnumberError; ?>
			
			<br><br>
			
			<label><b>Priority</b></label>
			
			<br><br>
			
			<select name="priority">
				<option value="high">High</option>
				<option value="normal">Normal</option>
				<option value="low">Low</option>
			</select>
			
			<br><br>
			
			<label>Notes</label><br>
			<input name="note" type="text">
			
			<br><br>
			
			
			<label>Color</label><br>
			<input name="color" type="color">
						
			<br><br>
			
			<h3>Problem description:</h3>
			
			
			<textarea name="comment" rows="5" cols="40"> </textarea>
			
			<br> <br>
			
			<input type="submit">
		
</form>
			

	
<h2 style="clear:both;">Information</h2>
<?php

	$html = "<table>";
		
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Firstname</th>";
			$html .= "<th>Lastname</th>";
			$html .= "<th>Notebook</th>";
			$html .= "<th>Serialnumber</th>";
			$html .="<th>Priority</th>";
			$html .= "<th>Notes</th>";
			$html .= "<th>Color</th>";
			$html .= "<th>Comment</th>";
		$html .= "</tr>";	
			
	foreach($notes as $note) {
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->firstname."</td>";
			$html .= "<td>".$note->lastname."</td>";
			$html .= "<td>".$note->notebook."</td>";
			$html .= "<td>".$note->serialnumber."</td>";
			$html .= "<td>".$note->priority."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
			$html .= "<td>".$note->comment."</td>";
		$html .= "</tr>";		
		
	}
	$html .= "</table>";
	
	echo $html;
?>	