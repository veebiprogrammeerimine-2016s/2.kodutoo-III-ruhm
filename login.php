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
	
	$gender = "";
		if(isset($_POST["gender"])) {
			if(!empty($_POST["gender"])){
				
			//on olemas ja ei ole tühi
			$gender = $_POST["gender"];
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
		$notice = $User->login($_POST["loginemail"], $_POST["loginpassword"]);
		
	}
	
	
	
	
 ?>

<!DOCTYPE html>

<link rel="stylesheet" href="Style/loginstyle.css">
<html>
	<head>
		<title>Sisselogimise leht</title>
		<div class="login-page">
	</head>
	<h1> Tere tulemast Töömehe Abisse versioon 1.1!</h1>
	
<body>
	<label style= "color:white">Logi sisse</label>
	<form class="form" method="POST"> 
		<p style="color:red;"><?php echo $notice; ?></p>
		<div class="input">
		<label>
		<div class="required">E-post:</div>
		<input name= "loginemail" type= "email" value="<?php echo $loginemail;?>"> <?php echo $loginemailError; ?>
		</label>
		</div>
			
		<div class="input">
		<label>
		<div class="required">Parool: </div>
		<input name="loginpassword" type="password" value="<?php echo $loginpassword;?>" /> <?php echo $loginpasswordError; ?>
		</label>
		</div>
		<div class="input">
		<button class="button">Esita</button>
		</div>
	</form>

</body>
	<label style= "color:white">Registreeri</label>	
 <form class="form" method="POST"> 
		
		<label>
		<div class="required">Eesnimi:</div>
		<input type= "text" name="firstname" />
		</label>
	
		<label>
		<div class="required">Perekonnanimi:</div>
	    <input type="text" name="lastname" />
		</label>
			
	
		<label>
		<div class="required">Sünnikuupäev:</div>
		<input type="date" name="birthday">
		</label>
			
			
		<label>
		<div class="required">Sinu sugu:</div>
		<?php if ($gender == "male") { ?>
		<input type="radio" name="gender" value="male" checked> Mees<br>
		<?php } else { ?>
		<input type="radio" name="gender" value="male"> Mees<br>
		<?php } ?>
		<?php if ($gender == "female") { ?>
		<input type="radio" name="gender" value="female"checked> Naine<br>
		<?php } else { ?>
		<input type="radio" name="gender" value="female"> Naine<br>
		<?php } ?>
		</label>
			
			
	<label>
	<div class="required">Sinu email:</div>
	<input name= "signupEmail" type= "email" value="<?php echo $signupEmail;?>" > <?php echo $signupEmailError; ?>
	</label>
		
			
	<label>
	<div class="required">Loo parool:</div>
	<input name="signupPassword" type="password"> <?php echo $signupPasswordError;?>
	</label>
			
	<button class="button">Loo kasutaja</button>
			
	</form>
</body>
</html>
