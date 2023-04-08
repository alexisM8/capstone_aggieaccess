
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
    <form action="AddCourse.php" method="POST">

    <label for="courseTitle">Enter Course Title:</label>
    <input type="text" id="courseTitle" name="courseTitle">

    <label for="crn">Enter Course Reference Number (CRN):</label>
    <input type="text" id="crn" name="crn">

    <label for="deptID">Enter Department ID:</label>
    <input type="text" id="dept_id" name="deptid">

    <input type="submit" name="submit" value="Create Course">
    </form>';
    if(isset($_POST['submit'])){
    $course_title = $_POST['courseTitle'];
    $course_CRN = $_POST['crn'];
    $dept_

// Define the SQL query
$sql_select = "SELECT * FROM crn WHERE crn='$teacher_email'";//change from fac to crn
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
    else
{
    echo "<table>";
    echo "<tr><th>Please Enter Student and Tecaher Email</th></tr>";
    
    echo "</table>";
}
}
else
{
header("Location: login.php");
}
?>