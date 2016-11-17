<?php
class Helper {
    function cleanInput ($input) {
    // removes unneeded spaces in front and behind the input
    $input = trim($input);
    // removes backwards slashes
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
    }
}
?>
