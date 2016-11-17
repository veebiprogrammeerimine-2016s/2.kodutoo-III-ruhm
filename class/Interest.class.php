<?php
class Interest {
    private $connection;
    function __construct($mysqli){
        $this->connection=$mysqli;
    }

    function getAll() {
		
		$stmt = $this->connection->prepare("
			SELECT id, interest
			FROM interests
		");
		echo $this->connection->error;
		
		$stmt->bind_result($id, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->id = $id;
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
	
		
		return $result;
	}
    
    function save ($interest) {
		

		$stmt = $this->connection->prepare("INSERT INTO interests (interest) VALUES (?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();

		
	}
    
    function saveUser ($interest) {
		$stmt = $this->connection->prepare("SELECT id FROM user_interests WHERE user_id=? AND interest=?");
        $stmt->bind_param("ii", $_SESSION["userId"],$interest);
        echo $this->connection->error;
        $stmt->execute();
        
        if($stmt->fetch()) {
            //stuff existed
            echo "You've already picked this one!";
            return;
        }
        
        $stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO user_interests (user_id, interest) VALUES (?, ?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("ii", $_SESSION["userId"],$interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();

		
	}
    
    function closeConnection() {
        $this->connection->close();
    }
}
?>
