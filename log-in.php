<?php

require("functions.php");
// Kui kasutaja on juba sisse loginud, siis suunan data.php lehele.
if(isset($_SESSION["userID"]))
	{
		
		header("Location: data.php");
	}

// muutujad
$loginEmailError="";
$signupEmailError = ""; 
$signupPasswordError="";
$birthdayError ="";
$loginPasswordError ="";
$signupGender="";
$signupEmail = "";
$loginEmail = "";

//kontrollin, kas väli on täidetud
if(isset($_POST["loginEmail"]))
{

	
// juhul kui on tühi, annan vastava teate
	if(empty($_POST["loginEmail"]))
	{
		$loginEmailError = "See väli on kohustuslik.";
	}
	else
	{
		$loginEmail = $_POST["loginEmail"];
	}
}
if(isset($_POST["loginPassword"] ))
{
	if(empty($_POST["loginPassword"]))
	{
		$loginPasswordError = "See väli on kohustuslik.";
	}
}
//kontrollin, kas väli on täidetud
if(isset($_POST["signupEmail"]))
{

	
// kui on täitmata
	if(empty($_POST["signupEmail"]))
	{
		$signupEmailError = "See väli on kohustuslik.";
	}
	else
	{
		$signupEmail = $_POST["signupEmail"];
	}
}

if(isset($_POST["signupPassword"] ))
{

	if(empty($_POST["signupPassword"]))
	{
		$signupPasswordError = "See väli on kohustuslik.";
	}
	else 
	{
		
		// kontrollin, et parooli pikkus oleks vähemalt 8tm
		if(strlen($_POST["signupPassword"]) < 8)
		{
			$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk.";
		}
	}
}
//kui väljad on täidetud
if(isset($_POST["birthDate"]) OR isset($_POST["birthMonth"]) OR isset($_POST["birthYear"]))
{
	
// kui täitmata
	if(empty($_POST["birthDate"]) OR empty($_POST["birthMonth"]) OR empty($_POST["birthYear"]))
	{
		$birthdayError = "See väli on kohustuslik.";
	}
	else
	{
		$birthday = $_POST["birthYear"].'-'.$_POST["birthMonth"].'-'.$_POST["birthDate"];
		
	}
}
if( isset( $_POST["signupGender"] ) ){
		
		if(!empty( $_POST["signupGender"] ) ){
		
			$signupGender = $_POST["signupGender"];
			
		}
		
	} 

	// kontollin, kas kõik on olemas
	if($signupEmailError == "" && $signupPasswordError == "" && $birthdayError == ""
							   && isset($_POST["signupEmail"]) && isset($_POST["signupPassword"]))
	{
		// salvestan andmed andmebaasi
		echo "Salvestan...<br>";
		
		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		
		
		$password = hash("sha512",$_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
		
		
		signUp(cleanInput($signupEmail),cleanInput($password),cleanInput($birthday),cleanInput($signupGender));
		
	}
	
	$error ="";
	if(isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"]))
	{
		$error = login(cleanInput($_POST["loginEmail"]),cleanInput($_POST["loginPassword"]));
	}
	
	
	
?>

<!DOCTYPE html>
<html>
<title>Avaleht</title>

<!--<link rel="stylesheet" type="text/css" href="style.css"> -->

<body>

<div class = "main">
<div class ="login">
<form method="POST">
	<h1>Logi sisse</h1>
	<?php echo $error; ?>
    <label for="loginEmail">E-mail: </label><?php echo $loginEmailError; ?>
	<input name="loginEmail" type="text" value="<?php echo $loginEmail;?>"><br><br>
    <label for="loginPassword">Parool: </label><?php echo $loginPasswordError; ?> 
	<input name="loginPassword" type="password"><br><br>
	
	<input type="submit" value="Logi sisse" class="button">
</form>
</div>

<div class="signup">
<form method="POST">
	<h1>Loo kasutaja</h1>
	<input name="signupEmail" placeholder="E-mail" type="text" value="<?php echo $signupEmail;?>"> <?php echo $signupEmailError; ?>
	<br><br>
	<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
	<br><br>
	<label for="birthday">Sünniaeg: DD/MM/YYYY</label>
    <br>
   	<select name="birthDate">
    		<option></option>
		<?php for($i = 1;$i<=31;$i++){
	echo "<option value=".$i.">$i</option><br>";
		}
		?>
	</select>
	<select name="birthMonth">
		<option></option>
		<?php for($i = 1;$i<=12;$i++){
	echo "<option value=".$i.">$i</option><br>";
		}
		?>
	</select>
	<select name="birthYear">
		<option></option>
		<?php for($i = 2003;$i>=1900;$i--){
	echo "<option value=".$i.">$i</option><br>";
		}
		?>
	</select>
           
    </select>
    <br>
    <?php echo $birthdayError; ?>
    <br><br>	
<?php
	if($signupGender == "male")
	{
?>
	<input type="radio" name="signupGender" value="male" checked>Mees
	<?php } else { ?>
	<input type="radio" name="signupGender" value="male">Mees
	<?php } ?>
	<?php
	if($signupGender == "female")
	{
?>
	<input type="radio"  name="signupGender" value="female" checked>Naine
	<?php } else { ?>
	<input type="radio" name="signupGender" value="female">Naine
	<?php } ?>
	

	
<input type="submit" value="Loo kasutaja" class="button">
	
	
	
</form>
</div>

</div>

</body>
</html>