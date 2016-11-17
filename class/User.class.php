<?php
class User {

    private $connection;
    
    function __construct($mysqli){
        $this->connection = $mysqli;
    } //Triggered, when new User and stuff included in () will get sent here.

function login($email, $password){
    
    $stmt = $this->connection->prepare("
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
	
	echo $this->connection->error;
	$stmt = $this->connection->prepare("INSERT INTO user_db_1 (email, password) VALUES (?, ?)");
	// s - string
	// i - int
	// d - decimal/double
	$stmt->bind_param("ss", $email, $password);
	if ($stmt->execute()) {
	echo("Your account was saved.");
	} else {
	echo($stmt->error);
	}
	echo $this->connection->error;
	$this->connection->close();
	echo("I REACHED IT");
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

}
?>
