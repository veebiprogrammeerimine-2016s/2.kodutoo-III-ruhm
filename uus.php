<?php

	require("../../../config.php");
	require("functions1.php");
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//kui kasutaja on sisse loginud, siis suuna data lehele
	if(isset ($_SESSION["userId"])) {
		header("Location: data1.php");
		exit();

	}
	
	$signupUsernameError = "";
	$signupUsername = "";
	
	if (isset ($_POST["signupUsername"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST["signupUsername"])) {
			
			//oli tõesti tühi
			$signupUsernameError = "See väli on kohustuslik";
			
		} else {
			//kõik korras, kasutaja koht ei ole tühi ja on olemas
			$signupUsername = $_POST["signupUsername"];
			
		}
	
	}

$signupEmailError = "";
	$signupEmail = "";
	
	if (isset ($_POST["signupEmail"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST["signupEmail"])) {
			
			//oli tõesti tühi
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
			//kõik korras, kasutaja koht ei ole tühi ja on olemas
			$signupEmail = $_POST["signupEmail"];
			
		}
	
	}

	$signupPasswordError = "";


	//kas on üldse olemas
	if (isset ($_POST["signupPassword"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST["signupPassword"])) {
			
			//oli tõesti tühi
			$signupPasswordError = "See väli on kohustuslik";
			
		} else {

			//oli midagi, ei olnud tühi

			// kas pikkus vähemalt 4
			// kuna kassas on kõigil oma 4-kohaline kood, võiks seda sama kasutada, et ei oleks liiga palju uusi paroole
			if (strlen ($_POST["signupPassword"]) < 4 ) {

				$signupPasswordError = "Parool peab olema vähemalt 4 tm pikk!";
			}
		}
	}

	
	if (isset($_POST["signupUsername"]) &&
			isset($_POST["signupEmail"]) &&
		 	isset($_POST["signupPassword"]) &&
		 	$signupUsernameError == "" && 
		 	$signupEmailError == "" &&
		 	empty($signupPasswordError)
		) {
			
			// ühtegi viga ei ole, kõik vajalik olemas
		
			echo "salvestan...<br>";
			//echo "kasutaja ".$signupUsername."<br>";
			//echo "parool ".$_POST["signupPassword"]."<br>";
		
			$password = hash("sha512", $_POST["signupPassword"]);
		
			//echo "räsi ".$password."<br>";
		
			//kutsun funktsiooni, et salvestada
			signup($signupUsername, $signupEmail, $password);

	}
	
	$notice = "";	
	//mõlemad login vormi väljad on täidetud
	if (	isset($_POST["loginUsername"]) &&
				isset($_POST["loginPassword"]) &&
				!empty($_POST["loginUsername"]) &&
				!empty($_POST["loginPassword"])
	) {

			login($_POST["loginUsername"], $_POST["loginPassword"]);
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		
		
		<form method="POST">
			
			<input placeholder="Kasutaja" name="loginUsername" type="text">
			
			<br><br>
			
			<input placeholder="Parool" name="loginPassword" type="password">
			
			
			<br><br>
			
			<input type="submit">
			
		
		</form>

	</body>
</html>


<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Loo kasutaja</h1>
		
		
		<form method="POST">
			<label>Eesnimi</label><br>
			<input name="Firstname" type="text"> 	

			<br><br>
			
			<label>Perekonnanimi</label><br>
			<input name="Lastname" type="text"> 

			<br><br>
			
			<label>Kasutajanimi</label><br>
			<input type="text" name="signupUsername" value="<?php echo $signupUsername; ?>">  <?php echo $signupUsernameError; ?>

			<br><br>

			<label>Email</label><br>
			<input type="email" name="signupEmail" value="<?php echo $signupEmail; ?>">  <?php echo $signupEmailError; ?>

			<br><br>

			
			<label>Parool</label><br>
			<input type="password" name="signupPassword"> <?=$signupPasswordError;?> 
			
			<br><br>
			
				<input type="submit" value="Loo kasutaja">
		
		</form>

	</body>
</html>