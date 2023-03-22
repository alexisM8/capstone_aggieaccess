
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
$f_id=$_SESSION['id'];
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {

$sql_select = "SELECT course.courseTitle, course.CRN, faculty.lname,faculty.fname, time.timeRange, date.startDate, date.endDate, rooms.roomNum, building.buildAbbrv
FROM course 
JOIN class ON course.courseID = class.courseID 
JOIN time ON class.timeID = time.timeID 
JOIN date ON class.dateID = date.dateID 
JOIN location ON class.locationID = location.locationID 
JOIN rooms ON location.roomID = rooms.roomID
JOIN building ON location.buildID = building.buildID
JOIN faculty ON class.profID = faculty.fid
where faculty.fid='$f_id'";
$result = $conn->query($sql_select);

// Check for errors in the SELECT query
if (!$result) {
    echo "Error selecting record: " . $conn->error;
} if (mysqli_num_rows($result) >0) {
    
    echo "<table>";
    echo "<tr><th>Course title</th><th>Course CRN</th><th>Faculty Name</th><th>Time</th><th>Start Date</th><th>end Date</th><th>room Num</th><th>build Abbrv</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["courseTitle"] . "</td><td>" . $row["CRN"] . "</td><td>" .
        $row["fname"] . " " . $row["lname"] . "</td><td>" . $row["timeRange"] . "</td><td>" . 
        $row["startDate"] . "</td><td>" . $row["endDate"] . "</td><td>" . $row["roomNum"] . "</td><td>" . $row["buildAbbrv"] . "</td>
        </tr>";
    }

    echo "</table>";
   
}
else {
    echo "<table>";
    echo "<tr><th>No Teacher Schdeule Find</th></tr>";
    
    echo "</table>";
}
}
else
{
header("Location: login.php");
}
?>