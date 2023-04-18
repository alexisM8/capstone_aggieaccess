<?php
require_once 'creds.php';
$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Fatal Error");
}



if (isset($_COOKIE['newcount'])) {
    $count = $_COOKIE['newcount'];
}
echo "<h1>"."Allow Seat upto    :" .$count."</h1>";
echo '<form method="POST" action="?page=GrantOverride">';
echo '<input type="submit" name="submit" value="Grant Override">';
echo '</form>';

if (isset($_POST['submit'])) {
    setcookie("count",($count) ,time() + 60 * 60* 60* 24, "/");
}
?>