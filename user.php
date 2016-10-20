<?php 
	
	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}
	
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
	
	if ( isset($_POST["interest"]) && 
		!empty($_POST["interest"])
	  ) {
		  
		saveInterest(cleanInput($_POST["interest"]));
		
	}
	if ( isset($_POST["userInterest"]) && 
		!empty($_POST["userInterest"])
	  ) {
		echo $_POST["userInterest"]."<br>";  
		saveUserInterest(cleanInput($_POST["userInterest"]));
		
	}
	
    $interests = getAllInterests();
	
?>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<h1>About the user</h1>
<style>
    ul {
        list-style-type: none;
        margin: 0px;
        padding: 0px;
        overflow: hidden;
        background-color: DarkSlateGray;
        }
    li {
        float: left;}
    a {
        display: block;
        padding: 8px
    }
    li a {
        display: block;
        padding: 8px;
        color: White;
        background-color: DarkSlateGray;
        text-decoration: none}
    li a:hover {
        background-color: DarkSlateBlue}
    li a:active {
        background-color: DimGray}
    .active {
    background-color: DarkSeaGreen;}
</style>

<nav>
<ul>
    
    <li><a href="data.php">Home</a></li>
    <li><a class="active" href="user.php">User</a></li>
    <li><a href="options.php">Options</a></li>
    <li style="float: right"><a href="?logout=1">Log out</a></li>
</ul>
</nav>

<?=$msg;?>

<h2 style="margin-top: 0px;">Salvesta hobi</h2>


<?php
    
    $listHtml = "<ul";
	
	foreach($interests as $i){
		
		
		$listHtml .= "<li style='float:none'>".$i->interest."</li>";
	}
    
    $listHtml .= "</ul>";
	
	echo $listHtml;
    
?>
<form method="POST">
	
	<label>Hobi/huviala nimi</label><br>
	<input name="interest" type="text">
	
	<input type="submit" value="Salvesta">
	
</form>



<h2>Kasutaja hobid</h2>
<form method="POST">
	
	<label>Hobi/huviala nimi</label><br>
	<select name="userInterest" type="text">
        <?php
            
            $listHtml = "";
        	
        	foreach($interests as $i){
        		
        		
        		$listHtml .= "<option value='".$i->id."'>".$i->interest."</option>";
        
        	}
        	
        	echo $listHtml;
            
        ?>
    </select>
    	
	
	<input type="submit" value="Lisa">
	
</form>
