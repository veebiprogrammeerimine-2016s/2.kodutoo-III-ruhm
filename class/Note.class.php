<?php
class Note {


    private $connection;
    
    function __construct($mysqli){
        $this->connection = $mysqli;
    }


function getAll($q, $sort, $order){
    $allowedSort= ["id", "note", "color"];
    if(!in_array($sort, $allowedSort)){
        $sort="id";
    }
    
    $orderBy = "ASC";
    
    if($order == "DESC"){
    $orderBy = "DESC";}
    //echo "q= ".$q.", sort= ".$sort.", order=".$order." ";
	if($q != "") {
	$query = "%".$q."%";
        $stmt = $this->connection->prepare("select id, note, color from colornotes where deleted is null and (note like ? or color like ?) order by $sort $orderBy");
        $stmt->bind_param("ss",$query, $query);
	} else {
        $stmt = $this->connection->prepare("select id, note, color from colornotes where deleted is null");
	}
	
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

function save($note, $color){
	

	echo $this->connection->error;
	$stmt = $this->connection->prepare("INSERT INTO colornotes (note, color) VALUES (?, ?)");
	// s - string
	// i - int
	// d - decimal/double
	$stmt->bind_param("ss", $note, $color);
	if ($stmt->execute()) {
	echo("Note is saved.");
	} else {
	echo($stmt->error);
	}
	echo $this->connection->error;
	$this->connection->close();
}


}
?>
