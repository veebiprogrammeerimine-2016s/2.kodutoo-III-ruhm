<?php


	require("functions.php");
	
	//kui kasutaja on sisse loginud suunan data lehele
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	//kas on üldse olemas
	
	$signupEmailError = "";
	$signupEmail = "";
	
	if(isset($_POST["signupEmail"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST["signupEmail"])) {
			
			//oli tühi 
			$signupEmailError = "you have to enter your email";
			
		} else {
			
			//all ok
			$signupEmail = $_POST["signupEmail"];
		}
	}
	$signupUsernameError = "";
	
	if(isset($_POST["signupUsername"])) {
		
			if (empty ($_POST["signupUsername"])) {
				
				$signupNameError = "you have to enter a username";
			}
	}
	$signupNameError = "";
	
	if(isset($_POST["signupName"])) {
		
			if (empty ($_POST["signupName"])) {
				
				$signupNameError = "you have to enter your name";
			}
	}
	$signupPasswordError = "";
	$signupPasswordConfirmError = "";
	//$signupPassword = "";
	//$signupPassword = $_POST["signupPassword"];
	if(isset($_POST["signupPassword"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST["signupPassword"])) {
			
			//oli tühi 
			$signupPasswordError = "you have to choose a password";
			
		} else {
		
		//ei olnud midagi
		
		//kas pikkus oli vähemalt 8 
		
		if (strlen ($_POST["signupPassword"]) < 8 ) {
			
			$signupPasswordError = "password must be at least 8 characters long";
			}
		}
		
		//lilith
		if ($_POST["signupPassword"] != $_POST["signupPasswordConfirm"]){
			$signupPasswordConfirmError = "password has to match";
			
		}
		
			
		
	}
		$gender = "";
	if(isset($_POST["gender"])) {
 	if(!empty($_POST["gender"])){
 			
 			//on olemas ja ei ole tühi
 			$gender = $_POST["gender"];
		}
	}
	
	if( isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		$signupEmailError == "" &&
		empty($signupPasswordError)
		){
		
		// ühegi viga pole, kõik vajalik olemas
		echo "saving...<br>";
		echo "email " .$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "hash ".$password. "<br>";
		
		//kitsun funkstiooni,  et salvestada
		signup($signupEmail, $password);
		
	}
	
	//mõlemad login vormi väljad on täidetud
	$notice = "";
	if (  isset($_POST["loginUsername"]) &&
		  isset($_POST["loginPassword"]) &&
		  !empty($_POST["loginUsername"]) &&
		  !empty($_POST["loginPassword"])
		) {
			 $notice = login($_POST["loginUsername"], $_POST["loginPassword"]);
		}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Login page</title>
	</head>
	<body>
	
		<h1>Log in</h1>
		
		<p style="color:red;"><?php echo $notice; ?></p>
		<form method="POST">
			<input placeholder="username" name="loginUsername" type="text" value="<?php echo $_POST['loginUsername']; ?>">
			
			<br><br>
			
			<input placeholder="password" name="loginPassword" type="password">
			
			<br><br>
			
			<input type="submit" value="Log in">
			
		
		</form>
		
		
		<h1>Sign up</h1>
		
		<form method="POST">
			
			<input placeholder="email" name="signupEmail" type="email"  value="<?php echo $signupEmail; ?>" > <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="username" name="signupUsername type="text">
			
			<br><br>
			
			<input placeholder="password" name="signupPassword" type="password">
			
			<input placeholder="confirm your password" name="signupPasswordConfirm" type="password">
			
			<br><br>
			
			<?php echo $signupPasswordError; ?>
			<?php echo $signupPasswordConfirmError; ?>
			
			
			
			<input placeholder="your name" name="signupName" type="text"> <?php echo $signupNameError; ?>
			
			<br><br>
			
			
		
			<input type="submit" value="sign up">
			
			
			<br><br>		
				
			<?php echo "who are you"; ?>
			
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

			<br><br>
			
		</form>
		
		<br><br>

			<h2>MVP</h2>
			
				<p> My idea for a MVP is a website where people can write whatever they wish anonymously, as long as their story fits in 666 characters.</p>
				<p> The page would be an endless scroll and the latest post would be on top of the page.</p>
	</body>
</html>
