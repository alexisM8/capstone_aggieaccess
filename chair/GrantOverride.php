<?php
require_once 'creds.php';
$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Fatal Error");
}
// if (isset($_COOKIE['newcount'])) {
//     $count = $_COOKIE['newcount'];
// }
            echo "<h2> Grant Override </h2> ";
            echo "<hr>";
            echo "<h3 style = color:red; ><strong> IMPORTANT NOTICE!!! </strong></h3>";
            echo "<p><strong> In order for there to be a class there must be a minimum of 12 students per class,<br> 
            with a maximum of 20 students per class. </strong> </p>";

echo '<form method="POST" action="?page=GrantOverride">';
echo '<input type="submit" name="submit" value="Grant Override">';
echo '</form>';
if (isset($_POST['submit'])) {
    setcookie("count",($count) ,time() + 60 * 60* 60* 24, "/");
}
?>