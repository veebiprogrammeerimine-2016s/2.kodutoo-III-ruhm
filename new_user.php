<?php
if (isset($_GET["back"])) {
    header("Location: login.php"); exit();}


?>

<h1 style="text-align:center; font-family: Roboto; font-weight: 100; font-size: 300%">Welcome to the club!</h1>
<p style="text-align:center; font-family: Roboto; font-weight: 250; font-size: 125%">
Your new user has been created. Feel free to log in now.<br>
<a href="?back=1">Go back or click this link to return.</a>
</p>
