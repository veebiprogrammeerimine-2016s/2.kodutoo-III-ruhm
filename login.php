<?php 

	
	require ("./functions.php");
	
	//kui kasutaja on sisse loginud, suunan data lehele
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	$loginEmailError = "";
	$loginEmail = "";
	if (isset ($_POST["loginEmail"])) {
		if (empty ($_POST["loginEmail"])) {
			$loginEmailError = "See väli on kohustuslik";
		} else {
			$loginEmail = $_POST["loginEmail"];
		}
		
	}
	
	$loginPasswordError = "";
	$loginPassword = "";
	if (isset ($_POST["loginPassword"])) {
		if (empty ($_POST["loginPassword"])) {
			$loginPasswordError = "See väli on kohustuslik";
		} else {
			$loginPassword = $_POST["loginPassword"];
		}
		
	}
	
		
	$signupEmailError = "";
	$signupEmail = "";
	if (isset ($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])) {
			$signupEmailError = "See väli on kohustuslik";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
		
	}
	
	$signupPasswordError = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupPassword"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli tühi
		if (empty ($_POST["signupPassword"])) {
			
			//oli tõesti tühi
			$signupPasswordError = "See väli on kohustuslik";
			
		} else {
			
			// oli midagi, ei olnud tühi
			
			// kas pikkus vähemalt 8
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tm pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			
			//on olemas ja ei ole tühi
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
	   ) {
		
		// ühtegi viga ei ole, kõik vajalik olemas
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		

		echo "räsi ".$password."<br>";
		
		//kutsun funktsiooni, et salvestada
		signup($signupEmail, $password);
		
		//ühendus
		$database = "if16_romil";
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO user_sample 
		(email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		// s - string
		// i - int
		// d - decimal/double
		//iga küsimärgi jaoks üks täht, mis tüüpi on
		$stmt->bind_param("ss", $signupEmail, $password );
		
		//täida käsku
		if ( $stmt->execute() ) {
			
			echo "salvestamine õnnestus";
			
		} else {
			
			echo "ERROR ".$stmt->error;
		}
		
		
	}	
	$notice = "";
	//mõlemad login vormi väljad on täidetud
	if( isset ($_POST["loginEmail"]) &&
		isset ($_POST["loginPassword"]) &&
		!empty ($_POST["loginEmail"]) &&
		!empty ($_POST["loginPassword"])
	
	){
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p><?php echo $notice; ?></p>
		<form method="POST">
			
			<label>E-post</label><br>
			<input name="loginEmail" type="email" value="<?=$loginEmail;?>" > <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<label>Parool</label><br>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
						
			<br><br>
			
			<input type="submit" value="Logi sisse">
		
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST">
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>" > <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
						
			<br><br>
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked > Mees<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male"> Mees<br>
			<?php } ?>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked > Naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Naine<br>
			<?php } ?>
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked > Muu<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other"> Muu<br>
			<?php } ?>
			
			<input type="submit" value="Loo kasutaja">
		
		</form>

	</body>
</html>