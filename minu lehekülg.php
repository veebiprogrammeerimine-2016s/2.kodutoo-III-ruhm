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
			text-align: center;
			font-family: 'Goudy Old Style', Garamond, 
			'Big Caslon', 'Times New Roman', serif;
			font-size:80px;
			color:#000000 ;
			}
		</style>
	</head>
	
	<body>
	
		<h1> Tere tulemast Töömehe Abisse versioon 1.1!</h1>
		
		<style type ="text/css">
	
		h2 {
			text-align: center;
			color: #ffffff;
		}
		</style>
		<h2>Logi sisse</h2>
		
		<form method="POST"> 
				<p style="color:red;"><?php echo $notice; ?></p>
		
			<div class="input">
			<label>
			<input name= "loginemail" type= "email" value="<?php echo $loginemail;?>" > <?php echo $loginemailError; ?>
			<div class="required">E-post:</div>
			</label>
			</div>
			
			<div class="input">
			<label>
				<input name="loginpassword" type="password" value="<?php echo $loginpassword;?>" /> <?php echo $loginpasswordError; ?>
			
				<div class="required">Parool: </div>
				</label>
			</div>
			<div class="input">
			<button class="button">Esita</button>
			</div>
			
		</form>

	</body>
</html>
		<h2>Loo kasutaja</h2>
		
		<form method="POST"> 
		<style type ="text/css">
		body {
			background-color:  #00b3b3;
			font-family: "Open Sans", Helvetica;
		}
		label {
			display: block;
			letter-spacing: 4px;
			padding-top: 30px;
			text-align: center;
		}
		label .required {
			color: #ffffff;
			cursor: text;
			font-size: 20px;
			line-height: 20px;
			text-transform: uppercase;
			transform: translateY(-34px);
			transition: all 0.3s;
		}
		label input {
		background-color: transparent;
		border: 0;
		border-bottom: 2px solid  #000000;
		color: white;
		font-size: 28px;
		letter-spacing: -1px;
		outline: 0;
		padding: 5px 20px;
		text-align: center;
		transition: all 0.3a;
		width: 250px;
		}
		label input:focus {
		width: 300px;
		}
		label input:focus + .required {
		color: #00b3b3;
		 font-size: 10px;
		 transform: translateY(-74px);
        }
		label input.value-exists + .required {
		font-size: 2px;
		transform: translateY(-100px);
		}
		button {
		background-color: #00b3b3;
		border: 2px solid white;
		border-radius: 23px;
		color: white;
		cursor: pointer;
		font-size: 20px;
		margin-top: 20px;
		padding: 15px 30px;
		text-transform: uppercase;
		transition: all 200ms;
		}
		button:hover, button:focus {
		background-color: white;
		color: #333333;
		outline: 0;
		}
		</style>
			<label>
			<input type= "text" name="firstname" />
			<div class="required">Eesnimi:</div>
			</label>
	
			<label>
			<input type="text" name="lastname" />
			<div class="required">Perekonnanimi:</div>
			</label>
			
	
			<label>
			<input type="date" name="birthday">
			<div class="required">Sünnikuupäev:</div>
			</label>
			
			
			<label>
			<input type="radio" name="gender" value="male" checked> Mees<br>
			<input type="radio" name="gender" value="female"> Naine<br>
			<div class="required">Sinu sugu:</div>
			</label>
			
			<label>
			<input name= "signupEmail" type= "email" value="<?php echo $signupEmail;?>" > <?php echo $signupEmailError; ?>
			<div class="required">Sinu email:</div>
			</label>
		
			
			<label>
			<input name="signupPassword" type="password"> <?php echo $signupPasswordError;?>
			<div class="required">Loo parool:</div>
			</label>
			
			
			<button class="button">Loo kasutaja-></button>
			
		</form>

	</body>
</html>
