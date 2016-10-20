<?php

	require("functions.php");
	
	// kui kasutaja on sisseloginud, siis suuna data lehele
	if(isset ($_SESSION["userID"])) {
		header("Location: data.php");
		exit();
	}

	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
			
	$signupEmailError = "";
	$signupEmail = "";
	
	//kas on üldse olemas
	if (isset ($_POST ["signupEmail"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST ["signupEmail"])) {
			
			//oli tõesti tühi
			$signupEmailError = "See v2li on kohustuslik!"; 
		
		} else {
			
			//kõik korras, email ei ole tühi ja on olemas
			$signupEmail = $_POST ["signupEmail"];
			
		}	
		
	}
	
	$signupPasswordError = "";
	
	//kas on üldse olemas
	if (isset ($_POST ["signupPassword"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST ["signupPassword"])) {
			
			//oli tõesti tühi
			$signupPasswordError = "Parool puudulik!"; 
			
		} else {
			//oli midagi, ei olnud tühi
			
			//kas pikkus vähemalt 8
			if (strlen ($_POST ["signupPassword"]) <8 ) {
				
				$signupPasswordError = "Parool peab olema v2hemalt 8 t2hem2rki!";
				
			}
		}
		
		
		
		// && tähendab and 
		if  ( isset($_POST["signupEmail"]) &&
			isset($_POST["signupPassword"])&&
			 $signupEmailError== "" &&
			 empty($signupPasswordError)
			
			) {

			//ühtegi viga ei ole, kõik vajalik olemas
			echo "Salvestan...";
			echo "email ".$signupEmail. "<br>";
			
			$password = hash ("sha512", $_POST ["signupPassword"]);
			
			echo "Räsi ".$password."<br>";
			
			//ühendus
			$database = "if16_krisroos_3";
			$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
			
			//käsk
			$stmt = $mysqli->prepare("INSERT INTO Kasutajad_sample (email, password) VALUES(?, ?)");
			
			echo $mysqli->error;
			
			//s- string
			//i- int
			//d-decimal/double
			//iga küsimärgi jaoks üks täht, mis tüüpi on
			$stmt->bind_param("ss", $signupEmail, $password);

			if($stmt->execute()) {
				
				echo "Salvestamine õnnestus! ";
			} else {
				
				echo "Error ".$stmt->error;
			}
			
			}
	}
	echo "siin";
	
	$loginemailError = "";
	$loginemail = "";
	
	//kas on üldse olemas
	if (isset ($_POST ["loginemail"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST ["loginemail"])) {
			
			//oli tõesti tühi
			$loginemailError = "E-post puudulik!"; 
		
		} else {
			
			//kõik korras, email ei ole tühi ja on olemas
			$loginemail = $_POST ["loginemail"];
			
		}	
		
	}
	
	$loginpasswordError = "";
	$loginpassword = "";
	
	//kas on üldse olemas
	if (isset ($_POST ["loginpassword"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST ["loginpassword"])) {
			
			//oli tõesti tühi
			$loginpasswordError = "Sisesta parool!"; 
		
		} else {
			
			//kõik korras, email ei ole tühi ja on olemas
			$loginpassword = $_POST ["loginpassword"];
			
		}	
		
	}

	
	$notice = "";
	// mõlemad login vormi väljad on täidetud
	if (	isset($_POST["loginemail"]) && 
			isset($_POST["loginpassword"]) && 
			!empty($_POST["loginemail"]) && 
			!empty($_POST["loginpassword"]) 
	) {
		$notice = login($_POST["loginemail"], $_POST["loginpassword"]);
		
	}
	
	
	
	
 ?>


<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
		<style type ="text/css">
		h1 {
			font family: "Palatino Linotype", "Book Antiqua",
			Palatino, serif;}
		</style>
	</head>
	
	<body>

		<h1>Logi sisse</h1>
		
		<form method="POST"> 
				<p style="color:red;"><?php echo $notice; ?></p>

			<label>E-post</label><br>
			<input name= "loginemail" type= "email" value="<?php echo $loginemail;?>" > <?php echo $loginemailError; ?>
			
			
			<br><br>
			
			<label>Parool</label><br>
			<input name="loginpassword" type="password" value="<?php echo $loginpassword;?>" > <?php echo $loginpasswordError; ?>
			
			<br><br>
			
			<input type= "submit">
			
		</form>

	</body>
</html>
		<h1>Loo kasutaja</h1>
		
		<form method="POST"> 
		
			<label>Eesnimi: </label><br>
			<input type= "text" name="firstname" class="required"><br>
			<label>Perekonnanimi: </label><br>
			<input type="text" name="lastname" class="required" >
			
			<br><br>
			
			

			
			<label>Sisesta oma sünnikuupäev </label><br>
			<input type="date" name="birthday">
			
			<br><br>
			
			<label>Sisesta oma sugu</label><br>
			<input type="radio" name="gender" value="male" checked> Mees<br>
			<input type="radio" name="gender" value="female"> Naine<br>
			
			<br><br>
			
			<label>Sisesta oma e-mail</label><br>
			<input name= "signupEmail" type= "email" value="<?php echo $signupEmail;?>" > <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<label>Loo parool</label><br>
			<input name="signupPassword" type="password"> <?php echo $signupPasswordError;?>
			
			<br><br>
			
			
			<input type= "submit" value="Loo kasutaja->">
			
		</form>

	</body>
</html>
