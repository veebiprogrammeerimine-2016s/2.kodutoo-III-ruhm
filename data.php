<?php 

	require("functions.php");
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	if (isset($_GET["logout"])) {
		session_destroy();

		header("Location: login.php");
		exit();
	}
	
	if (	isset($_POST["toit"]) && 
			isset($_POST["kalorid"]) && 
			!empty($_POST["toit"]) && 
			!empty($_POST["kalorid"]) 
	) {
		
		$toit = cleanInput($_POST["toit"]);
		$kalorid = cleanInput($_POST["kalorid"]);
		
		saveInfo($_POST["toit"], $_POST["kalorid"]);
		
	}
	$toidud = getAllInfo();
	//echo "<pre>";
	//var_dump($notes);
	//echo "</pre>";

?>

<h1>Data</h1>
<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">Logi välja</a>
</p>
<h2><i>Märkmed</i></h2>
<form method="POST">
			
	<label>Toit</label><br>
	<input name="toit" type="text">
	
	<br><br>
	
	<label>Kalorid</label><br>
	<input name="kalorid" type="text">
				
	<br><br>
	
	<input type="submit">

</form>



<h2 style="clear:both;">Tabel</h2>
<?php 

	$html = "<table>";
		
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Toit</th>";
			$html .= "<th>Kalorid</th>";
		$html .="</tr>";

	foreach ($toidud as $Toit) {
		$html .= "<tr>";
			$html .= "<td>".$Toit->id."</td>";
			$html .= "<td>".$Toit->toit."</td>";
			$html .= "<td>".$Toit->kalorid."</td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;

?>




