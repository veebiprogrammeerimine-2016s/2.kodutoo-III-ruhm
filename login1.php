<?php 
	
	require("functions.php");
	
	//kui kasutaja sisse logitatud, siis suuna data.php lehele
	if(isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
		
	$loginEmailError = "";
	$loginEmail = "";
	
	//kas on üldse olemas
	if (isset ($_POST["loginEmail"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli tühi
		if (empty ($_POST["loginEmail"])) {
			
			//oli tõesti tühi
			$loginEmailError = "Must be filled in!";
			
		} else {
				
			// kõik korras, email ei ole tühi ja on olemas
			$loginEmail = $_POST["loginEmail"];
		}
		
	}
	
	$signupEmailError = "";
	$signupEmail = "";
	
	if (isset ($_POST["signupEmail"])) {
		
		if (empty ($_POST["signupEmail"])) {
			
			$signupEmailError = "Must be filled in!";
			
		} else {
				
			$signupEmail = $_POST["signupEmail"];
		}
		
	}	
		$loginPasswordError = "";

	if (isset ($_POST["loginPassword"])) {
		
		if (empty ($_POST["loginPassword"])) {
			
		$loginPasswordError = "Must be filled in!";
	
		
		}
	}
		$signupPasswordError = "";

	if (isset ($_POST["signupPassword"])) {
		
		if (empty ($_POST["signupPassword"])) {
			
			$signupPasswordError = "Must be filled in!";
			
		} else {
		
			
			// kas pikkus vähemalt 8
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Password must contain at least 8 symbols!";
				
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
		echo "Saving...<br>";
		echo "email ".$signupEmail."<br>";
		echo "password ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "hash ".$password."<br>";
		
		//kutsun funktsiooni, et salvestada
		signup($signupEmail, $password);
		
		
		
	}	
		
	
	
	$notice = "";
	// mõlemad login vormi v2ljad on t2endatud
	if (	isset($_POST["loginEmail"]) &&
			isset($_POST["loginPassword"]) &&
			!empty($_POST["loginEmail"]) &&
			!empty($_POST["loginPassword"])
	) {
		
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
	}
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Welcome</title>
	</head>
	<body>

		<h1>Sign in</h1>
		
		<form method="POST">
			
			<label>E-mail</label><br>
			<p style="color:red;"></p>
			<input name="loginEmail" type="email" value="<?=$loginEmail;?>" > <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<label>Password</label><br>
			<p style="color:red;"><?php echo $notice; ?></p>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
						
			<br><br>
			
			<input type="submit">
		
		</form>
		
		<h1>Sign up</h1>
		
		<form method="POST">
			
			<label>E-mail</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>" > <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Password" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
						
			<br><br>
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked > Male<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male"> Male<br>
			<?php } ?>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked > Female<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Female<br>
			<?php } ?>
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked > Other<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other"> Other<br>
			<?php } ?>
			
			<br>
			
			<input type="submit" value="Sign up">
		
		</form>

	</body>
</html>