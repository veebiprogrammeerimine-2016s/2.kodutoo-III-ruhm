<?php
	
	require("functions.php");
	require("styles.css");
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	//echo "<br>";
	$gender = "";
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
		
		if (!isset($_POST["gender"])) {
			
			$signupGenderError = "Choose your gender.";
		} else {
			
			$gender = $_POST['gender'];
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
			$password = hash("sha512", $_POST["signupPassword"]);
			//kutsun funktsiooni, et salvestada
			$signupEmail = cleanInput($signupEmail);
			signup(cleanInput($_POST["signupUsername"]), 
					$signupEmail, 
					$password, 
					$gender, 
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
			<input name="signupUsername" type="text" value="<?php if(isset($_POST['signupUsername'])) { echo $_POST['signupUsername'];}?>" ><br>
			<b><?php echo $signupUsernameError; ?></b><br>
			<label>E-mail *</label><br>
			<input name="signupEmail" type="email" value="<?php if(isset($_POST['signupEmail'])) { echo $_POST['signupEmail'];}?>"><br>
			<b><?php echo $signupEmailError; ?></b><br>
			<label>Password *</label><br>
			<input placeholder="Password" type="password" name="signupPassword">
			<br>
			<b><?php echo $signupPasswordError; ?></b>
			<br><br>
			<?php if ($gender == "male"){ ?>
				<input type="radio" name="gender" value="male" checked>Male *
			<?php } else { ?>
				<input type="radio" name="gender" value="male">Male *
			<?php } ?>

			
			
			<?php if ($gender == "female") { ?>
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