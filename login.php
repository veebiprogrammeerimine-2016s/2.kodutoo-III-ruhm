<?php
	
	require("functions.php");
	require("styles.css");
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	//echo "<br>";
	var_dump($_POST);
	$signupPassword = "";
	$signupGender = "";
	$gender = "";
	$signupEmail = "";
	$signupUsernameError = "";
	$signupEmailError = "";
	$signupGenderError = "";
	$signupPasswordError = "";
	$signupBirthdateError = "";
	$Day = "";
	$Month = "";
	$Year = "";
	//on olemas
	if (isset ($_POST["signupUsername"])){
		
		if (empty($_POST["signupUsername"])){
			$signupUsernameError = "Enter your username.";
		
		}
		if (empty($_POST["signupEmail"])){
		
			$signupEmailError = "Enter your e-mail aadress.";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
		
		if (isset($_POST["gender"])) {
			//on olemas ja ei ole tühi
			$signupGender = $_POST["gender"];
		} else {
			$signupGenderError = "Choose your gender.";
		}
		if (empty($_POST['Day']) ||
			empty($_POST['Month']) ||
			empty($_POST['Year'])){

			$signupBirthdateError = 'Enter your date of birth.';
		
		} else {

			$Day = $_POST['Day'];
			$Month = $_POST['Month'];
			$Year = $_POST['Year'];
		}
		
	}
	
	//kas pikkus v'hemalt 8
	if (isset($_POST["signupPassword"]) && strlen($_POST["signupPassword"]) < 8) {
			
		$signupPasswordError = "Password must be at least 8 characters.";
		
	}
	if (isset($_POST["signupUsername"]) && (strlen($_POST["signupUsername"]) < 6 
		|| strlen($_POST["signupUsername"] > 16))){
		
		$signupUsernameError = "Username must be between 6-16 characters long.";
		
	} 


	if (empty($signupUsernameError) && 
		empty($signupEmailError) &&
		empty($signupPasswordError) &&
		empty($signupGenderError) &&
		empty($signupBirthdateError) &&
		isset($_POST["signupUsername"]) &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		isset($_POST["gender"])) {
			
			echo "saving...<br>";
			echo "email: ".$signupEmail."<br>";
			$password = cleanInput($_POST["signupPassword"]);
			$password = hash("sha512", $_POST["signupPassword"]);
			
			echo "password: ".$_POST["signupPassword"]."<br>";
			echo "hash: ".$password."<br>";
			
			
			//kutsun funktsiooni, et salvestada
			$signupEmail = cleanInput($signupEmail);
			signup($_POST["signupUsername"], 
					$signupEmail, 
					$password, 
					$signupGender, 
					($Year.'-'.$Month.'-'.$Day));
		}
			
	$notice = "";		
	//login vormi väljad täidetud
	if (	isset($_POST["loginUsername"]) &&
			isset($_POST["loginPassword"]) &&
			!empty($_POST["loginUsername"]) &&
			!empty($_POST["loginPassword"])){
			
			$notice = login(cleanInput($_POST["loginUsername"]), cleanInput($_POST["loginPassword"]));
		}
	elseif (isset($_POST["loginUsername"]) &&
			isset($_POST["loginPassword"]) &&
			!empty($_POST["loginUsername"]) &&
			empty($_POST["loginPassword"])){
			
			$notice = "Enter password!";
		}
		
	elseif (isset($_POST["loginUsername"]) &&
			isset($_POST["loginPassword"]) &&
			empty($_POST["loginUsername"]) &&
			!empty($_POST["loginPassword"])){
			
			$notice = "Enter your username!";
		}
		
	elseif (isset($_POST["loginUsername"]) &&
			isset($_POST["loginPassword"]) &&
			empty($_POST["loginUsername"]) &&
			empty($_POST["loginPassword"])){
			
			$notice = "Enter your username and password!";
		}

?>

<html>
	<head>
		<title>Login</title>

	</head>
	<body>
		<div class="container">
		<h1> Login </h1>
		<p style="color:red;"><?php echo $notice; ?></p>
		
			<form method="POST">
				<label>Username</label><br>
				<input name="loginUsername" type="text" 
				value="<?php if(isset($_POST['loginUsername'])) { echo $_POST['loginUsername']; }?>"><br>
				<label>Password</label><br>
				<input placeholder="Password" type="password" name="loginPassword">
				<br><br>
				<input type="submit" value="Login">
			<br><br>
			</form>
		
		
		<h1> Register </h1>
		<form method="POST">
			<label>Username *</label><br>
			<input name="signupUsername" type="text"><br>
			<b><?php echo $signupUsernameError; ?></b><br>
			<label>E-mail *</label><br>
			<input name="signupEmail" type="email" value="<?php $signupEmail?>"><br>
			<b><?php echo $signupEmailError; ?></b><br>
			<label>Password *</label><br>
			<input placeholder="Password" type="password" name="signupPassword" value="<?php $signupPassword?>">
			<br>
			<b><?php echo $signupPasswordError; ?></b>
			<br><br>
			<?php if ($signupGender == "male") { ?>
				<input type="radio" name="gender" value="male" checked>Male *
			<?php } else { ?>
				<input type="radio" name="gender" value="male">Male *
			<?php } ?>
			
			<?php if ($signupGender == "female") { ?>
				<input type="radio" name="gender" value="female" checked>Female *
			<?php } else { ?>
				<input type="radio" name="gender" value="female">Female *
			<?php } ?>
			<br>
			<b><?php echo $signupGenderError; ?></b>
			<br><br>
			
			<select name="Day">
			<option name="Day" value="<?php $Day?>"> Day </option> 
			<?php
			for($i=1; $i<=31; $i++){
				echo '<option value='.$i.'>'.$i.'</option>';
			}
			?>
			</select>
			<select name="Month">
			<option name="Month" value="<?php $Month?>"> Month </option>
			<?php
			for($i=1; $i<=12; $i++){
				echo '<option value='.$i.'>'.$i.'</option>';
			}
			?>
			</select>
			<select name="Year">
			<option name="Year" value="<?php $Year?>"> Year </option>
			<?php
			for($i=1930; $i<=2010; $i++)
				echo '<option value='.$i.'>'.$i.'</option>';
			?>
			</select>
			<br>
			<b><?php echo $signupBirthdateError;?></b> 
			<br><br>
			<input type="submit" value="Register">
		</form>
		</div>
		<br><br>
		<p>MVP idee: Enda poolt arendatavale m2ngule koduleht.</p>
	</body>
</html>