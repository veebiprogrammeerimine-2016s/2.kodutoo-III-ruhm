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
	
	$email = "";
	$band = "";
	$song = "";
	$genre = "";
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		unset($_SESSION["message"]);
	}
	
	if (isset($_POST["band"])&&
		isset($_POST["song"])&&
		isset($_POST["genre"])&&
		!empty($_POST["band"])&&
		!empty($_POST["song"])&&
		!empty($_POST["genre"])){
			
			$band = cleanInput($_POST["band"]);
			$song = cleanInput($_POST["song"]);
			$genre = cleanInput($_POST["genre"]);
			
	}
		
	if(isset($_POST["band"]) &&
		isset($_POST["song"]) &&
		isset($_POST["genre"]) &&
		!empty($_POST["band"]) &&
		!empty($_POST["song"]) &&
		!empty($_POST["genre"])) {
			
		saveData($_SESSION["userEmail"], $_POST["band"], $_POST["song"], $_POST["genre"]);
		
	}	
	
	$saveData = getMusicData();
	
?>	
	<!DOCTYPE html>
<html>
	<body>
		<p><a href="data.php"> <button onclick="goBack()">Go Back</button></a></p> 
		<h1>Music</h1>
		<?=$msg;?>
			<p>
			Welcome <?=$_SESSION["userEmail"];?>!
			<a href="?logout=1">Log out</a>
			</p>

		<h2> Add data </h2>
		
			<form method="POST">
				
				<label>Band:</label><br>
				<input name="band" type="text" value="<?=$band;?>">
				
				<br><br>
				
				<label>Song:</label><br>
				<input name="song" type="text" value="<?=$song;?>">
				
				<br><br>

				
				<label>Song genre:</label><br>
					<select name="genre">
						<option value="Alternative" <?php echo $result['genre'] == 'Alternative' ? 'selected' : ''?> >Alternative</option>
						<option value="Anime" <?php echo $result['genre'] == 'Anime' ? 'selected' : ''?>>Anime</option>
						<option value="Blues" <?php echo $result['genre'] == 'Blues' ? 'selected' : ''?>>Blues</option>
						<option value="ChildrensMusic" <?php echo $result['genre'] == 'Children’s Music' ? 'selected' : ''?> >ChildrensMusic</option>
						<option value="Classical" <?php echo $result['genre'] == 'Classical' ? 'selected' : ''?>>Classical</option>
						<option value="Comedy" <?php echo $result['genre'] == 'Comedy' ? 'selected' : ''?>>Comedy</option>
						<option value="Country" <?php echo $result['genre'] == 'Country' ? 'selected' : ''?>>Country</option>
						<option value="DanceEMD" <?php echo $result['genre'] == 'Dance / EMD' ? 'selected' : ''?> >Dance / EMD</option>
						<option value="Electronic" <?php echo $result['genre'] == 'Electronic' ? 'selected' : ''?>>Electronic</option>
						<option value="HipHopRap" <?php echo $result['genre'] == 'Hip-Hop/Rap' ? 'selected' : ''?>>Hip-Hop/Rap</option>
						<option value="Jazz" <?php echo $result['genre'] == 'Jazz' ? 'selected' : ''?>>Jazz</option>
						<option value="New Age" <?php echo $result['genre'] == 'New Age' ? 'selected' : ''?>>New Age</option>
						<option value="Pop" <?php echo $result['genre'] == 'Pop' ? 'selected' : ''?>>Pop</option>
						<option value="Reggae" <?php echo $result['genre'] == 'Reggae' ? 'selected' : ''?>>Reggae</option>
						<option value="Rock" <?php echo $result['genre'] == 'Rock' ? 'selected' : ''?>>Rock</option>
						</select>
					
				<input type="submit" value="Submit">
				
			
		</form>
	</body>
</html>

<br><br>

<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>

<?php
	
		$html = "<table>";
		
		$html .= "<tr>";
				$html .="<th>id</th>";
				$html .="<th>email</th>";
				$html .="<th>band</th>";
				$html .="<th>song</th>";
				$html .="<th>genre</th>";
		$html .= "</tr>";
		
		foreach($saveData as $i){
			
		$html .= "<tr>";
				$html .= "<td>".$i->id."</td>";
				$html .= "<td>".$i->email."</td>";
				$html .= "<td>".$i->band."</td>";
				$html .= "<td>".$i->song."</td>";
				$html .= "<td>".$i->genre."</td>";
		$html .= "</tr>";
		}
			
		$html .= "</table>";
		
		echo $html;
		
	
	
?>