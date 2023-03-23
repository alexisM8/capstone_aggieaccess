
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
{
echo '<html>';
    echo '
    <form action="?page=ContactTeacher" method="POST">
    <label for="username">Enter Teacher First Name:</label>
    <input type="text" id="username" name="username">
    <label for="username1">Enter Teacher Last Name:</label>
    <input type="text" id="username1" name="username1">
    <input type="submit" name="submit" value="Contact">
    </form>';
    if(isset($_POST['submit'])){
    $firstname = $_POST['username'];
    $lastname = $_POST['username1'];
// Define the SQL query
$sql_select = "SELECT * FROM faculty WHERE fname='$firstname' and lname='$lastname'";
$result = $conn->query($sql_select);

// Check for errors in the SELECT query
if (!$result) {
    echo "Error selecting record: " . $conn->error;
} if (mysqli_num_rows($result) >0) {
    
    echo "<table>";
    echo "<tr><th>Teacher Name</th><th>Teacher Email</th><th>Teacher Phone number</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["fname"] . " " . $row["lname"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td></tr>";
    }

    echo "</table>";
   
}
else {
    echo "<table>";
    echo "<tr><th>No Teacher Found</th></tr>";
    
    echo "</table>";
}
    }
    else
{
    echo "<table>";
    echo "<tr><th>Please Enter Teacher First Name and Last Name</th></tr>";
    
    echo "</table>";
}
}
else
{
header("Location: login.php");
}
?>