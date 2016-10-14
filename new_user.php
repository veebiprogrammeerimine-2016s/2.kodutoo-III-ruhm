<?php
if (isset($_GET["back"])) {
    header("Location: login.php"); exit();}


?>
<style>
    body {
        text-align: center;
        font-family: Roboto;    
        color: DarkSlateGray;
    }
    h1 {
        font-size: 300%;
        font-weight: 100;
        }
    p {
        font-size: 125%;
        font-weight: 250;
    }
</style>
<h1 >Welcome to the club!</h1>
<p>
Your new user has been created. Feel free to log in now.<br>
<a href="?back=1">Go back or click this link to return.</a>
</p>
