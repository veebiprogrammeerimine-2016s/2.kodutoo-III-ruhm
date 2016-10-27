<?php

												//Tuli ette error mida ei osanud lõpuks parandada :: error Column 'street' cannot be null :: error tuli kui teha uut kasutajat.

	require("../../config.php");
	require("functions.php");
	
	//kui kasutaja on sisseloginud, siis suuna data lehele
	if(!isset ($_SESSION["userId"])) {
		header("Loaction: data.php");
		
	}
	//<?php echo $m > ---- <?== $m >

	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	$signupEmailError = "";
	$signupEmail = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupEmail"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupEmail"])) {
			//oli tõesti tühi
			$signupEmailError = "See väli on kohustuslik";
		} else {
			// kõik korras, emal ei ole tühi ja on olemas
			$signupEmail = $_POST["signupEmail"];
		}
	}

	$signupPasswordError = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupPassword"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupPassword"])) {
			//oli tõesti tühi
			$signupPasswordError = "See väli on kohustuslik";
			
		} else {
			//oli midagi, ei olnud tühi
			//kas pikkust vähemalt 8
			
			if (strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
				
			}
				
			
			
			
			
		}
	}
	$creditcardnrError = "";
	
	if (isset ($_POST["creditcardnr"])) {
	
		if (empty($_POST["creditcardnr"])) {
			$creditcardnrError = "See väli on kohustuslik";
		}
		
	}
	$cscnrError = "";
	
	if (isset($_POST["cscnr"])) {
		
		if (empty($_POST["cscnr"])) {
			$cscnrError = "See väli on kohustuslik";
		}
	}
	$streetError = "";
	
	if (isset($_POST["street"])) {
		
		if (empty($_POST["street"])) {
			$streetError = "See väli on kohustuslik";
		}
	}
	$cityError = "";
	
	if (isset($_POST["city"])) {
		
		if (empty($_POST["city"])) {
			$cityError = "See väli on kohustuslik";
		}
	}
	$postalcodeError = "";
	
	if (isset($_POST["postalcode"])) {
		
		if (empty($_POST["postalcode"])) {
			$postiindeksError = "See väli on kohustuslik";
		}
	}
	
	
	if (isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		isset($_POST["creditcardnr"]) &&
		isset($_POST["cscnr"]) &&
		isset($_POST["street"]) &&
		isset($_POST["city"]) &&
		isset($_POST["postalcode"]) &&
		$streetError == "" &&
		$cityError == "" &&
		$postalcodeError == "" &&
		$creditcardnrError == "" &&
		$cscnrError == "" &&
		$signupEmailError == "" && 
		empty($signupPasswordError)
		
		) {
		
		// ühtegi viga ei ole, kõik vajalik olemas.
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		//echo "parool ". $_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		//echo "räsi ".$password."<br>";
		
		//kutsun functiooni, et salvestada
		
		signup(
		cleanInput($_POST["signupEmail"]), cleanInput($_POST["signupPassword"]), 
		cleanInput($_POST["creditcardnr"]), cleanInput($_POST["cscnr"]), 
		cleanInput($_POST["street"]), cleanInput($_POST["city"]), cleanInput($_POST["postalcode"]));
		
		
	}
	
	$notice = "";
	//Mõlemad login väljad on täidetud
	if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])){
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
	}
	
	
?>
<!DOCTYPE html>
<html style=" width: 100%; height: 100%;">
	<head>
		<title>Sisselogimis leht</title>
		
	</head>
	<body style=" width: 100%; height: 100%; background-position: center center; background-repeat:no-repeat; background-size: cover;" background="https://farm1.staticflickr.com/691/20664938416_4e4b224684_h.jpg">

		<h1>Logi sisse</h1>
		<p style="color:red;"><?php echo $notice; ?></p>
		<form method="POST">
			
			
			<input placeholder="E-mail" name="loginEmail" type="email">
			
			<br><br>
			
			<input placeholder="Parool" name="loginPassword" type="password">
			
			
			<br><br>
			
			<input type="submit">
		
		</form>

		<h1>Loo kasutaja</h1>
		
		<form method="POST">
		
			<input placeholder="E-mail" name="signupEmail" type="email" value="<?php echo $signupEmail; ?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			<br><br>
			
			
			Krediitkaardiinfo
			<br><br>
			<input placeholder="Krediitkaardi nr." name="creditcardnr" type="number"> <?php echo $creditcardnrError; ?>
			<br><br>
			<input placeholder="CSC" name="cscnr" type="number"> <?php echo $cscnrError; ?>
			<br><br>
			Aadress
			<br><br>
			<input placeholder="Tänav" name="street" type="text"> <?php echo $streetError; ?>
			<br><br>
			<input placeholder="Linn/vald" name="city"  type="text"> <?php echo $cityError; ?>
			<br><br>
			<input placeholder="Postiindeks" name="postalcode" type="text"> <?php echo $postalcodeError; ?>
			<br><br>
			<input type="submit" value="Loo kasutaja">
		
		</form>
	</body>
</html>