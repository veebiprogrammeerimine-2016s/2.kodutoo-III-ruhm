<?php
	require("functions.php");
	
	if(!isset($_SESSION["userID"]))
	{
		//suunan sisselogimise lehele
		header("Location: log-in.php");
		
		
		exit();
	}
	
	if(isset($_GET["logout"]))
	{
		session_destroy();
		header("Location: log-in.php");
	}
	$msg="";
	if(isset($_SESSION["message"]))
	{
		$msg = $_SESSION["message"];	
			unset($_SESSION["message"]);
	}
	
	if(isset($_POST["book"]) && isset($_POST["buyer"]) && isset($_POST["price"]) && isset($_POST["contact"])
		&& !empty($_POST["book"]) && !empty($_POST["buyer"]) && !empty($_POST["price"]) && !empty($_POST["contact"]))
	{
		updatebook(cleanInput($_POST["book"]),cleanInput($_POST["buyer"]),cleanInput($_POST["price"]),cleanInput($_POST["contact"]));
		header("Location: data.php");
	}
	
	
	
	
	
	
	
	$bookDetails = getAllbookDetails();
	
?>
<!-- kasutan jqueryt valikute peitmiseks/näitamiseks-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $(".hide").hide();
    });
    $("#show").click(function(){
        $(".hide").show();
    });
	$(".deletebook").click(function(e){
        var c = confirm("Hoiatus! Kas oled kindel, et soovid andmed kustutada?");
		
		if(!c){
			e.preventDefault();
			return;
		}
		else
		{
			
			<?php
			if(isset($_GET["remove"]))
			{
					deletebook();
					header("Location: data.php");
			}
			
			?>
			
		}
    });
	$(".editbook").click(function(ev){

				<?php			    
					foreach($bookDetails as $book)
					{
						if($_GET["edit"] == $book->id)
						{
							$bookName = $book->book;
							$bookbuyer = $book->buyer;
							$bookprice = $book->price;
							$bookContact = $book->contact;
							
							break;
						}															
			}
			
			?>			
		
	
    });
});
</script>
<?=$msg;?>
<p>Tere tulemast! <?=$_SESSION["userEmail"];?>!</p>
<a href="?logout=1">Logi välja</a>
<a href="data.php" > Tagasi </a>
<?php
foreach($bookDetails as $book)
					{
						if($_GET['edit'] == $book->id)
						{
							$bookName = $book->book;
							$bookbuyer = $book->buyer;
							$bookprice = $book->price;
							$bookContact = $book->contact;
							
							break;
						}				
					}
					?>	

<form method="POST" id="update">
    
	<h1>Andmed</h1>
	<label for="book">Raamat: </label>
	<input name="book" type="text" value="<?php if(isset($bookName)){ echo $bookName;}?>"><br><br>
	
	<label for="buyer">Ostja nimi: </label>
	<input name="buyer" type="text" value="<?php if(isset($bookbuyer)){ echo $bookbuyer;}?>"><br><br>
	
	<label for="price">Raamatu hind: </label>
	<input name="price" type="date" value="<?php if(isset($bookprice)){ echo $bookprice;}?>"><br><br>
	
	<label for="contact">Ostja kontaktandmed: </label>
	<input name="contact" type="text" value="<?php if(isset($bookContact)){ echo $bookContact;}?>"><br><br>
	
	<input type="submit" value="Update" class="updateButton" >
</form>




<h1 id="hide" style="cursor:pointer;">Peida</h1>
<h1 id="show" style="cursor:pointer;">Näita detaile</h1>



<?php
$html = "";
$i = 1;
	foreach($bookDetails as $book)
	{
		$html .= "<div class='details'>";
		$html .= "<p>".$i.")"." ".$book->book." <a class='editbook' href='?edit=".$book->id."'><img class='edit' src='pencil.gif' title='Edit' height='20' width='20'></a>
		<a class='deletebook' href='?remove=".$book->id."'><img class='remove' src='delete.gif' title='Remove' height='20' width='20'></a>
		 ";
	
		$i+=1;
		$html .= "<p class='hide'>".$book->buyer."</p>";
		$html .= "<p class='hide'>".$book->price."</p>";
		$html .= "<p class='hide'>".$book->contact."</p>";
		$html .= "</div>";
		
	}
	echo $html;
?>