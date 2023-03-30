
<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    // Replace the student email with the desired student's email
session_start();
$student_id = $_SESSION['id'];
$student_user = $_SESSION['user_type'];
$login_check=$_SESSION['loggedin'];
  if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='student'))
  {
// Prepare the SQL statement
$sql = "SELECT course.courseTitle,course.CRN FROM enrollment
        JOIN student ON enrollment.studentID = student.sid
        JOIN class ON enrollment.classID = class.classID
        JOIN course ON course.courseID = class.courseID
        WHERE student.sid = '$student_id'";

// Execute the SQL statement and get the result
$result = mysqli_query($conn, $sql);

// Check if there are any results
if ($result) {
if (mysqli_num_rows($result) >0) {

    // Create a table to display the results
    echo "<table>";
    echo "<tr><th>Course Name</th><th>Course CRN</th></tr>";

    // Loop through the results and display them in the table
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["courseTitle"] . "</td><td>"  . $row["CRN"] ."</td></tr>";
    }

    echo "</table>";

} else {
    echo "No courses found for this student.";
}
}
else {
    // display error message if query execution failed
    echo 'Error executing query: ' . mysqli_error($conn);
}
//This is a test
// Close the database connection
$conn->close();
}
else
{
  header("Location: login.php");
}
?>