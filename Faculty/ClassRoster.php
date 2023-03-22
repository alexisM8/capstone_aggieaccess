
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();

    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
    echo '
    <form action="?page=ClassRoster" method="POST">
    <label for="username">Enter Course CRN:</label>
    <input type="text" id="username" name="username">
    <input type="submit" name="submit" value="Show List Of Student">
    </form>';
    if(isset($_POST['submit'])){
$classname = $_POST['username'];
$sql_select = "SELECT student.fname, student.lname, student.email 
FROM enrollment 
JOIN student ON enrollment.studentID = student.sid 
JOIN class ON enrollment.classID = class.classID
JOIN time ON class.timeID = time.timeID
JOIN course ON course.courseID = class.courseID
WHERE course.CRN = '$classname'";
$result = $conn->query($sql_select);

// Check for errors in the SELECT query
if (!$result) {
    echo "Error selecting record: " . $conn->error;
} if (mysqli_num_rows($result) >0) {
    
    echo "<table>";
    echo "<tr><th>Student Name</th><th>Student Email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["fname"] .$row['lname']. "</td><td>" .$row['email']. "</td></tr>";
    }

    echo "</table>";
   
}
else {
    echo "<table>";
    echo "<tr><th>No Class Found</th></tr>";
    
    echo "</table>";
}
}
  }
else
{
header("Location: login.php");
}
?>