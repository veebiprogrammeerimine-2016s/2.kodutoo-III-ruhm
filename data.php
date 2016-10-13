<?php
	
	require("functions.php");
	
	$Feedback = "";
	$Color = "";
	if(!isset ($_SESSION["userId"])) {
		header("Location: register.php");
		exit();
	}
	
	// kas kasutaja tahab valja logida
	//kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: register.php");
		exit();
	}
	// ei ole tuhjad
	if (isset($_POST['note']) &&
		isset($_POST['color']) &&
		!empty($_POST['note']) &&
		!empty($_POST['color'])){
			
			$Note = $_POST['note'];
			$Color = $_POST['color'];
			$Note = cleanInput($Note, $Color)
			saveFeedback($Note, $Color);
			header("Location: data.php");
			exit();
		}
	
	$feedback = getFeedback();
	//echo "<pre>";
	//var_dump($notes[0]->noteColor);
	//echo "</pre>";

?>

<html>
	
	<body>
		<h1>Profile</h1>
		<p>Welcome <?=$_SESSION["username"];?>!</p><br>
		<p>Email: <?=$_SESSION["userEmail"];?></p>
		<p>Gender: <?=$_SESSION["gender"];?></p>
		<p>Birthdate: <?=$_SESSION["birthdate"];?></p>
		<p>Profile created: <?=$_SESSION["created"];?></p>
		<p><a href="?logout=1">Log out</a></p>

		<h2>Submit feedback</h2>
			<form method="POST">
			<label>Feedback</label><br>
			<textarea name="feedback"><?php $Feedback ?></textarea><br> 
			<label>Color</label><br>
			<input type="color" name="color" value="<?php $Color?>">
			<br><br>
			<input type="submit" value="Submit">
			</form>
		<br><br>
		</form>
		<h2>Archive</h2>
		<?php 
			foreach ($feedback as $f) {
				
				$style = "width:100px;
							float:left;
							min-height:50px; 
							border: 1px solid gray;
							background-color: ".$n->noteColor.";";
				
				echo "<p style='	".$style."	'>".$f->note."</p>";
			}
		?>
		
		<h2 style="clear:both;">Tabel</h2>
		<?php
			
			$html = "<table border=1>";
				$html .= "<tr>";
					$html .= "<th>Username</th>";
					$html .= "<th>Feedback</th>";

				$html .= "</tr>";
			foreach($feedback as $f) {
				$html .= "<tr>";
					$html .= "<td>".$_SESSION["username"]->Username."</td>";
					$html .= "<td>".$f->Feedback."</td>";
				$html .= "</tr>";
			}
			$html .= "</table>";
			
			echo $html;
		?>
	</body>

</html>