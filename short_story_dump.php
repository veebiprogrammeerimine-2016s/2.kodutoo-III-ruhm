<?php
			require("../../../config.php");
		
	session_start();

	$database = "if16_brigitta";
	
	
	function saveStory($author, $story) {
			
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO story_dump (author, story) VALUES(?,?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $author, $story);
		
		if ($stmt->execute() ) {
			
			echo "saving success";
		} else {
			
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	function getAllStories() 	{
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, author, story FROM story_dump");
		
		$stmt->bind_result($id, $author, $story);
		$stmt->execute();
		
		$result = array();
		
	
		while($stmt->fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id = $id;
			$object->author = $author;
			$object->story = $story;
			
			
			array_push($result, $object);
		}
		return $result;
		
	}
saveStory($_POST["username"], $_POST["story"]);
?>


<!DOCTYPE html>
<html>
	<head>
		<title>story_dump</title>
	</head>
	<body>
	
		<h1>write your deepest darkest secrets here</h1>
	
		<form method="POST">
	
			<input name="username" placeholder="username" type="text">
			
			
			<br><br>
			
			<textarea name="story" style="width: 300px; height: 150px;" placeholder="speak your mind.."></textarea>
		
			<br><br>
		
			<input type="submit" value="submit">
	
		
		</form>
		

</html>
