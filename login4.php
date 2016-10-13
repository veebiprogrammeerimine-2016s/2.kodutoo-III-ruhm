<?php

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
	$nrError = "";
	
	if (isset ($_POST["nr"])) {
		
		if (empty($_POST["nr"])) {
			$nrError = "See väli on kohustuslik";
		}
		
	}
	$cscnrError = "";
	
	if (isset($_POST["cscnr"])) {
		
		if (empty($_POST["cscnr"])) {
			$cscnrError = "See väli on kohustuslik";
		}
	}
	$tanavError = "";
	
	if (isset($_POST["tanav"])) {
		
		if (empty($_POST["tanav"])) {
			$tanavError = "See väli on kohustuslik";
		}
	}
	$linnvaldError = "";
	
	if (isset($_POST["linn/vald"])) {
		
		if (empty($_POST["linn/vald"])) {
			$linnvaldError = "See väli on kohustuslik";
		}
	}
	$postiindeksError = "";
	
	if (isset($_POST["postiindeks"])) {
		
		if (empty($_POST["postiindeks"])) {
			$postiindeksError = "See väli on kohustuslik";
		}
	}
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			
			//on olemas ja ei ole tühi
			$gender = $_POST["gender"];
		}
	}
	
	if (isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		isset($_POST["nr"]) &&
		isset($_POST["cscnr"]) &&
		isset($_POST["tanav"]) &&
		isset($_POST["linn/vald"]) &&
		isset($_POST["postiindeks"]) &&
		$tanavError == "" &&
		$linnvaldError == "" &&
		$postiindeksError == "" &&
		$nrError == "" &&
		$cscnrError == "" &&
		$signupEmailError == "" && 
		empty($signupPasswordError)
		
		) {
		
		// ühtegi viga ei ole, kõik vajalik olemas.
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ". $_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "räsi ".$password."<br>";
		
		//kutsun functiooni, et salvestada
		
		signup($signupEmail, $password);
		
		
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
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Mees<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" > Mees<br>
			<?php } ?>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Naine<br>
			<?php } ?>
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Muu<br><br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other"> Muu<br><br>
			<?php } ?>
			
			Krediitkaardiinfo
			<br><br>
			<input placeholder="Krediitkaardi nr." name="nr" type="number"> <?php echo $nrError; ?>
			<br><br>
			<input placeholder="CSC" name="cscnr" type="number"> <?php echo $cscnrError; ?>
			<br><br>
			Aadress
			<br><br>
			<input placeholder="Tänav" name="tanav" type="text"> <?php echo $tanavError; ?>
			<br><br>
			<input placeholder="Linn/vald" name="linn/vald"  type="text"> <?php echo $linnvaldError; ?>
			<br><br>
			<input placeholder="Postiindeks" name="postiindeks" type="text"> <?php echo $postiindeksError; ?>
			<br><br>
			<input type="submit" value="Loo kasutaja">
		
		</form>
	</body>
</html>