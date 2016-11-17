<?php

require("../functions.php");
require("../class/User.class.php");
require("../class/Helper.class.php");
$User = new User($mysqli);
$Helper = new Helper();
if(isset($_SESSION["userId"])) {
header("Location: data.php");
exit();
}
$signupEmailError = "";
$signupNameError = "";
$signupBUError = "";
$signupPasswordError = "";
$controlPasswordError = "";
$forgotEmailNotif = "";
$signupEmail = "";
$loginEmail = "";
$signupName = "";
$signupBUEmail = "";
if (isset ($_POST["signupName"])){
    if (!empty($_POST["signupName"])){
        $signupName = $_POST["signupName"];
    }
}
if (isset($_POST["signupBUEmail"]) && !empty($_POST["signupBUEmail"])){
    $signupBUEmail = $_POST["signupBUEmail"];
}
if (isset ($_POST["loginEmail"] ) ) {
	if (!empty($_POST["loginEmail"])){
		$loginEmail = $_POST["loginEmail"];
	}
}
if (isset ($_POST["forgotEmail"] ) ) {
	if (empty($_POST["forgotEmail"])){
		$forgotEmailNotif = "To reset your password, please enter your email.";
	} else {
        notifyForgottenUser($_POST["forgotEmail"]);
		$forgotEmailNotif = "An email notification has been sent to you.";
	}
}
if (isset ($_POST["signupEmail"] ) ) {
	//somebody PRESSED THE BUTTON
	if (empty($_POST["signupEmail"])){
		$signupEmailError = "Please enter your e-mail";		
	} else {
		$signupEmail = $_POST["signupEmail"];
	}
}
if (isset ($_POST["signupPassword"] ) ) {
	if (empty($_POST["signupPassword"])){
		$signupPasswordError = "Please enter a password.";
	} else {
		// length of at least 8 characters
		if (strlen ($_POST["signupPassword"]) < 8) { $signupPasswordError = "Please make sure your password is at least 8 characters long.";}
	}
}
if (isset ($_POST["signupName"])){
	if (empty($_POST["signupName"])) {
		$signupNameError = "Please enter your display name.";
	}
}
if (isset ($_POST["controlPassword"])){
    if (empty($_POST["controlPassword"])){
        $controlPasswordError = "Please retype your password for security purposes.";
    } else {
        if ($_POST["signupPassword"] != $_POST["controlPassword"]){
        $controlPasswordError = "The passwords you have typed are not the same";
        }
    }

}
if (isset ($_POST["signupBUEmail"])){
	if (empty($_POST["signupBUEmail"])){
		$signupBUError = "Please enter a backup email account.";
	} else {
		if ($_POST["signupEmail"]==$_POST["signupBUEmail"]){
			$signupBUError = "Your regular email and backup email cannot be the same.";
		}
	}
}	
if (isset($_POST["signupEmail"]) && isset($_POST["signupPassword"]) && isset($_POST["controlPassword"]) && empty($signupEmailError) && empty($signupPasswordError) && empty($signupNameError) && empty($signupBUError) && empty($controlPasswordError)){
	echo "Saving information...";
	echo "E-mail: ".$signupEmail."<br>";
	echo "Passwd: ".$_POST["signupPassword"]."<br>";
	$password = hash("sha512", $_POST["signupPassword"]);
	echo "Hashed ".$password."<br>";


	$User->signUp($signupEmail, $password, $_POST["signupName"], $_POST["signupBUEmail"]);
	header("Location: new_user.php");
	//connect to MariaDB, since I'm cool
}

if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty(["loginPassword"])) {
	$User->login($_POST["loginEmail"], $_POST["loginPassword"]);
}

?>
<?php require("../header.php"); ?>

<title>Login Page</title>
<style>
    legend {
        font-weight: 500;
    }
</style>

<!--<link rel="stylesheet" type="text/" href="mystyle.css">-->
<div class="container">
	
	<div class="row">
        <!--<h1>My awesome website for some reasons</h1>-->
        <div class="col-sm-4 col-md-3">
		<h2 style="margin-top:0px;">Log into the system</h2>
		<fieldset>
		<legend>Login information</legend>
		<form method="POST">
		<label>E-mail address</label>	
		<br>
		<div class="form-group">
		<input class="form-control" name="loginEmail" type="email" value="<?php echo $loginEmail; ?>" autofocus>
		</div>
		<br><br>
		<label>Password</label>
		<br>
		<input name="loginPassword" type="password">
		<br><br>
		<input class="btn btn-success hidden-xs" type="submit" value="Log in">
		<input class="btn btn-success btn-block visible-xs-block" type="submit" value="Log in 2">
		</form>
		</fieldset>
		</div>
		
        <div class="col-sm-4 col-md-3 col-sm-offset-1 col-md-offset-1">
		<h2>Create a user</h2>
		<fieldset>
		<legend>Information for creating a user</legend>
		<form method="POST">
		<label>E-mail address</label>
		<br>
		<input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>"><?php echo $signupEmailError; ?>
		<br><br>
		<label>Password</label>
		<br>
		<input name="signupPassword" type="password"><?php echo $signupPasswordError; ?>
		<br><br>
		<label>Retype your Password</label>
		<br>
		<input name="controlPassword" type="password"><?php echo $controlPasswordError; ?>
		<br><br>
		<label>Display name</label>
		<br>
		<input name="signupName" type="text" value="<?php echo $signupName; ?>"><?php echo $signupNameError; ?>
		<br><br>
		<label>Backup email address</label>
		<br>
		<input name="signupBUEmail" type="text" value= "<?php echo $signupBUEmail; ?>"><?php echo $signupBUError; ?>
		<br><br>
		<input class="btn" type="submit" value="Create User">
		<!--<input type="submit" value="Create user">-->
		</form>
		</fieldset>
        </div>
        
        <div class="col-sm-3 col-sm-offset-1">
		<h2>Forgot your password?</h2>
		<fieldset>
		<legend>Email information</legend>
		<p>Please be notified of the following things:<br> * Password retrieving by email is not operational as of yet;<br> * Our servers do not store your password, therefore a new password must be generated.
		</p>
		<form method="POST">
		<label>E-mail address</label>
		<br>
		<input name="forgotEmail" type="email"><?php echo $forgotEmailNotif; ?>
		<br><br>
		<button class="button" type="submit">Send email confirmation</button>
		</form>
		</fieldset>
		</div>
		</div>
    </div>
<?php require("../footer.php"); ?>
