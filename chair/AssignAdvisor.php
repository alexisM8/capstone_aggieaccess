
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
    <form action="?page=AssignAdvisor" method="POST">
    <label for="username">Enter Student Email:</label>
    <input type="email" id="username" name="username">
    <label for="faculty">Enter Teacher Email:</label>
    <input type="email" id="faculty" name="faculty">
    <input type="submit" name="submit" value="Assign Advisor">
    </form>';
    if(isset($_POST['submit'])){
    $teacher_email = $_POST['faculty'];
    $email = $_POST['username'];
// Define the SQL query
$sql_select = "SELECT * FROM faculty WHERE email='$teacher_email'";
$result = $conn->query($sql_select);

// Check for errors in the SELECT query
if (!$result) {
    echo "Error selecting record: " . $conn->error;
} if (mysqli_num_rows($result) >0) {
    // Get the selected data and store it in variables
    $row = $result->fetch_assoc();
    $id = $row["fid"];
    

    // Update the table with the new email address
    $sql_update = "UPDATE student SET advisorID='$id' WHERE email='$email'";
    
    if ($conn->query($sql_update) === TRUE) {
        if (mysqli_affected_rows($conn) > 0) {
            echo "Record updated successfully";
        } 
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
else
{
    echo "<table>";
    echo "<tr><th>teacher not exist</th></tr>";
    
    echo "</table>";
}
    }
}
else
{
header("Location: login.php");
}
?>