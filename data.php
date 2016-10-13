<?php
	
	require("functions.php");
	require("styles.css");
	$Feedback = "";
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
	if (isset($_POST['feedback']) &&
		!empty($_POST['feedback'])){
			
			$Feedback = $_POST['feedback'];
			$Feedback = cleanInput($Feedback);
			saveFeedback($Feedback);
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

		<h2>Send feedback</h2>
			<form method="POST">
			<label>Feedback</label><br>
			<textarea name="feedback"><?php $Feedback ?></textarea><br> 
			<br><br>
			<input type="submit" value="Submit">
			</form>
		<br><br>
		</form>

		
		<h2 style="clear:both;">Feedback table</h2>
		<div class="table">
		<?php
			
			$html = "<table>";
				$html .= "<tr>";
					$html .= "<th>Username</th>";
					$html .= "<th>Feedback</th>";
				$html .= "</tr>";
			foreach($feedback as $f) {
				$html .= "<tr>";
					$html .= "<td>".$f->username."</td>";
					$html .= "<td>".$f->feedback."</td>";
				$html .= "</tr>";
			}
			$html .= "</table>";
			
			echo $html;
		?>
		</div>
	</body>

</html>