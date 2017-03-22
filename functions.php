
<?php
require("../../config.php");

	session_start();
	
	
	function signUp($email,$password,$birthday,$gender)
	{
		// ühendan andmebaasiga
		$database = "if16_helemand";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli käsklus
		$stmt = $mysqli->prepare("INSERT INTO login (email,password,birthday,gender) VALUES (?,?,?,?)");
		
		
		
		echo $mysqli->error; 

		$stmt->bind_param("ssss",$email,$password,$birthday,$gender); 

		if($stmt->execute())
		{
			echo "salvestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function saveBook($bookTitle,$bookBuyer, $bookPrice, $buyerContact)
	{
		$database = "if16_helemand";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli käsklus
		$stmt = $mysqli->prepare("INSERT INTO book_details (books, buyer, price, contact) VALUES (?,?,?,?)");
		
		
		echo $mysqli->error;
		
		$stmt->bind_param("ssds",$bookTitle,$bookBuyer, $bookPrice, $buyerContact); 
		
		
		if($stmt->execute())
		{
			echo "salvestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	function saveBookdt($book,$buyer,$price,$contact)
	{
		$database = "if16_helemand";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$mysqli->set_charset("utf8");
		// sqli rida
		$stmt = $mysqli->prepare("INSERT INTO book_details (book,buyer,price,contact) VALUES (?,?,?,?)");
		
		
		echo $mysqli->error; 
		

		$stmt->bind_param("ssss",$book,$buyer,$price,$contact);
		
	
		if($stmt->execute())
		{
			echo "salvsestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	function login ($email,$password)
	{
		$error = "";
		
		$database = "if16_helemand";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT id,email,password FROM login WHERE email = ?");
		
		
		echo $mysqli->error; 
		
		// asendan küsimärgi
		$stmt ->bind_param("s",$email);
		
		//määran väärtused
		$stmt ->bind_result($id,$emailFromDb,$passwordFromDb);
		// päring
		$stmt ->execute();
		
		// kas andmebaasis oli andmeid?
		if($stmt->fetch())
		{
			
			$hash = hash("sha512",$password); 
			echo $passwordFromDb;
			echo $emailFromDb;
			echo $id;
			if($hash == $passwordFromDb )
			{
				echo "Kasutaja logis sisse ".$id;
				
				
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				exit();
				
			}
			else
			{
				$error = "vale email või parool";
			}
		}
		else
		{
			// ei leidnud kasutajat selle meiliga
			$error = "vale email voi parool";
		}
		
		return $error;
	}
	
	
	function deletebook()
	{
			$database = "if16_helemand";
				$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
				$mysqli->set_charset("utf8");
			    
				
				$dealID = $_GET['remove'];
				
				$stmt = $mysqli->prepare("DELETE FROM book_details  WHERE id = '$dealID'");
				
				
				echo $mysqli->error;
				
				
				
				if($stmt->execute())
				{
					echo "salvestamine õnnestus";
				}
				else
				{
					echo "ERROR ".$stmt->error;
				}
				
				
				$stmt->close();
				$mysqli->close();
		
	}
	function updatebook($book,$buyer,$price,$contact)
	{
		
		$database = "if16_helemand";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$mysqli->set_charset("utf8");
		// sqli rida
		$dealID = $_GET['edit'];
		
		$stmt = $mysqli->prepare("UPDATE  book_details SET books='$book', buyer='$buyer', price='$price',contact='$contact' WHERE id = '$dealID'");
		
		echo $mysqli->error; 
				
				
				
				if($stmt->execute())
				{
					echo "salvsestamine õnnestus";
				}
				else
				{
					echo "ERROR ".$stmt->error;
				}
				
				
				$stmt->close();
				$mysqli->close();
	}
	
	function getAllbookDetails()
	{
		$database = "if16_helemand";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		$mysqli->set_charset("utf8");
		
		
		$stmt = $mysqli->prepare("SELECT id,books,buyer,price,contact FROM book_details ORDER BY price ASC");
		
		
		
		$stmt ->bind_result($id,$books,$buyer,$price,$contact);
		$stmt->execute();
		
		
		//loon massiivi
		$result=array();
		
		
		//võtan andmed
		while($stmt->fetch())
		{
			//tekitan objekti
			$bookDetails = new StdClass();
			
			$bookDetails->id = $id;
			$bookDetails->book = $books;
			$bookDetails->buyer = $buyer;
			$bookDetails->price = $price;
			$bookDetails->contact = $contact;
			
			 
			array_push($result, $bookDetails);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
			
	function cleanInput($input)
	{
		$input = trim($input);
		$input = htmlspecialchars($input);
		$input = stripslashes($input);
		
		return $input;
	}
	
	
	
	
	
	
?>