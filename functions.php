<?php
require("config.php");
//for using $_SESSION stuff
//in all files that are connected with functions.php
session_start();

$db = "logindb";
function login($email, $password){
$mysqli = new mysqli(
	$GLOBALS["serverHost"],
	$GLOBALS["serverUsername"],
	$GLOBALS["serverPassword"],
	$GLOBALS["db"]
	);

echo(
	$GLOBALS["serverHost"].
	$GLOBALS["serverUsername"].
	$GLOBALS["serverPassword"].
	$GLOBALS["db"]
	);
$stmt = $mysqli->prepare("
	SELECT id, email, password, created
	FROM user_db_1
	WHERE email = ?
");
$stmt->bind_param("s", $email);

$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
echo($id.", ".$emailFromDb);
$stmt->execute();

if ($stmt->fetch()) {
	$hash = hash("sha512", $password);
	if ($hash == $passwordFromDb) {
		//echo "User with ID ".$id." logged in.";
		$_SESSION["userId"] = $id;
		$_SESSION["userEmail"] = $emailFromDb;
		header("Location: data.php");
		exit();
	} else {
		echo "The password seems to be wrong. Please try again.";
	}
} else {
	echo "The e-mail address seems to be wrong. Please try again.";
	}

}


function signUp($email, $password, $displayname, $backupemail){
	$mysqli = new mysqli(
	$GLOBALS["serverHost"],
	$GLOBALS["serverUsername"],
	$GLOBALS["serverPassword"],
	$GLOBALS["db"]
	);

	echo $mysqli->error;
	$stmt = $mysqli->prepare("INSERT INTO user_db_1 (email, password) VALUES (?, ?)");
	// s - string
	// i - int
	// d - decimal/double
	$stmt->bind_param("ss", $email, $password);
	if ($stmt->execute()) {
	echo("Your account was saved.");
	} else {
	echo($stmt->error);
	}
	echo $mysqli->error;
	$mysqli->close();
	echo("I REACHED IT");
}

function saveNote($note, $color){
	$mysqli = new mysqli(
	$GLOBALS["serverHost"],
	$GLOBALS["serverUsername"],
	$GLOBALS["serverPassword"],
	$GLOBALS["db"]
	);

	echo $mysqli->error;
	$stmt = $mysqli->prepare("INSERT INTO colornotes (note, color) VALUES (?, ?)");
	// s - string
	// i - int
	// d - decimal/double
	$stmt->bind_param("ss", $note, $color);
	if ($stmt->execute()) {
	echo("Note is saved.");
	} else {
	echo($stmt->error);
	}
	echo $mysqli->error;
	$mysqli->close();
}


function getAllNotes(){
$mysqli = new mysqli(
	$GLOBALS["serverHost"],
	$GLOBALS["serverUsername"],
	$GLOBALS["serverPassword"],
	$GLOBALS["db"]
	);
	$stmt = $mysqli->prepare("select id, note, color from colornotes");
	$stmt->bind_result($id, $note, $color);
	$stmt->execute();
	$result = array();

	while($stmt->fetch()) {
		
		$object = new StdClass();
		$object->id = $id;
		$object->note = $note;		
		$object->notecolor = $color;
		array_push($result, $object);
	}
	return $result;
}

function cleanInput ($input) {
    // removes unneeded spaces in front and behind the input
    $input = trim($input);
    // removes backwards slashes
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function notifyForgottenUser ($email) {
        $try_inoperational = 0;
        if ($try_inoperational = 0){
            $fp = fopen("forgotten_passwords.log", "w") or die("Sorry, but this didn't work.");
            $fpdata = "forgotten password for email ".$email;
            fwrite($fp, $fpdata);
            fclose($fp);
        } else {
            echo("We're sorry, but this does not work as of yet.");}
            
}

?>
