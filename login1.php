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
	
	//kas on �ldse olemas
	if (isset ($_POST["loginEmail"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli t�hi
		if (empty ($_POST["loginEmail"])) {
			
			//oli t�esti t�hi
			$loginEmailError = "See v�li on kohustuslik";
			
		} else {
				
			// k�ik korras, email ei ole t�hi ja on olemas
			$loginEmail = $_POST["loginEmail"];
		}
		
	}
	
	$signupEmailError = "";
	$signupEmail = "";
	
	//kas on �ldse olemas
	if (isset ($_POST["signupEmail"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli t�hi
		if (empty ($_POST["signupEmail"])) {
			
			//oli t�esti t�hi
			$signupEmailError = "See v�li on kohustuslik";
			
		} else {
				
			// k�ik korras, email ei ole t�hi ja on olemas
			$signupEmail = $_POST["signupEmail"];
		}
		
	}	
		$loginPasswordError = "";
	//kas on �ldse olemas
	if (isset ($_POST["loginPassword"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli t�hi
		if (empty ($_POST["loginPassword"])) {
			
			//oli t�esti t�hi
			$loginPasswordError = "See v�li on kohustuslik";
	
		
		}
	}
		$signupPasswordError = "";
	//kas on �ldse olemas
	if (isset ($_POST["signupPassword"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli t�hi
		if (empty ($_POST["signupPassword"])) {
			
			//oli t�esti t�hi
			$signupPasswordError = "See v�li on kohustuslik";
			
		} else {
			
			// oli midagi, ei olnud t�hi
			
			// kas pikkus v�hemalt 8
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema v�hemalt 8 tm pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			
			//on olemas ja ei ole t�hi
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
	   ) {
		
		// �htegi viga ei ole, k�ik vajalik olemas
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "r�si ".$password."<br>";
		
		//kutsun funktsiooni, et salvestada
		signup($signupEmail, $password);
		
		
		
	}	
		
	
	
	$notice = "";
	// m�lemad login vormi v2ljad on t2endatud
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
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		
		<form method="POST">
			
			<label>E-post</label><br>
			<p style="color:red;"></p>
			<input name="loginEmail"  value="edgar.s95@hotmail.com" type="email"> <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<label>Parool</label><br>
			<p style="color:red;"><?php echo $notice; ?></p>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
						
			<br><br>
			
			<input type="submit">
		
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