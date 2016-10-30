<?php
	//et saada ligi sessioonile)
	require("functions.php");
	
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	

//kas kasutaja tahab välja logida
//kas aadrrssireal on logout olemas
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	if (  isset($_POST["note"]) &&
		  isset($_POST["color"]) &&
		  !empty($_POST["note"]) &&
		  !empty($_POST["color"])
		) {
			
			$note = cleanInput($_POST["note"])
			saveNote($note, $_POST["color"]);
		}


	$notes = getAllNotes();
	//echo "<pre>";
	//var_dump($notes);
	//echo "</pre>";
?>

<h1>DATA</h1>
<p>Welcome <?=$_SESSION["userEmail"];?>!
<br><br>
<a href="?logout=1">Log Out</a>
</p>



	<h1>Notes</h1>
	
	<form method="POST">
	
			<label>note</label><br>
			<input name="note" type="text">
			
			<br><br>
			
			<input name="color" type="color">
			
			<br><br>
			
			<input type="submit" value="Save">
	</form>
	<h2>archive</h2>
	
	<?php
		//iga liikme kohta massiivis
		foreach ($notes as $n) {
			
			$style = "width:100px; float:left; min-height:100px; border:1px solid gray; background-color:".$n->noteColor.";";
			echo "<p style=' ".$style." '>".$n->note."</p>";
		}
	
	
	?>
	
	<h2 style="clear:both;">table</h2>
<?php

	$html = "<table>";
	
		$html .= "<tr>";
			$html .="<th>id</th>";
			$html .="<th>note</th>";
			$html .="<th>color</th>"; 
		$html .="</tr>";
		
	foreach ($notes as $note) {
			$html .= "<tr>";
			$html .="<td>".$note->id."</td>";
			$html .="<td>".$note->note."</td>";
			$html .="<td>".$note->noteColor."</td>"; 
		$html .="</tr>";
		
		
	}

	$html .= "</table>";
	
	echo $html;


?>		