
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();


        $sql = "SELECT f.email ,f.fname,f.lname,f.phone
        FROM  faculty AS f";

    $result = $conn->query($sql);

    $row = mysqli_fetch_assoc($result);
    echo "<b>Your Information:</b>";
    echo "<table>";
    echo "<tr><th>First Name</th><th>Last Name</th></tr>";
    
    echo "<tr><td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td></tr>";
    echo "</table>";

    echo "<table>";
    echo "<tr><th>Faculty Email</th><th>Phone Number</th></tr>";
    $row = mysqli_fetch_assoc($result);
    echo "<tr><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td></tr>";
    echo "</table>";

    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
$sql_select = "SELECT DISTINCT c.courseTitle AS Course_Title,
f.fname AS FirstName,   
f.lname AS LastName,      
t.timerange AS Time,        
d.days AS Meeting_Days,        
dt.startDate AS Start_Date,        
dt.endDate AS End_Date,        
r.roomNum AS Room 
FROM course AS c INNER JOIN class AS cl ON c.courseID = cl.courseID 
INNER JOIN enrollment AS e ON cl.classID = e.classID 
INNER JOIN faculty AS g ON e.facultyID = g.fid
INNER JOIN enrollment AS z ON cl.classID = z.classID AND z.facultyID = g.fid
INNER JOIN faculty AS f ON z.facultyID = f.fid 
INNER JOIN time AS t ON cl.timeID = t.timeID 
INNER JOIN day AS d ON cl.dayID = d.daysID 
INNER JOIN date AS dt ON cl.dateID = dt.dateID 
INNER JOIN location AS l ON cl.locationID = l.locationID 
INNER JOIN rooms AS r ON l.roomID = r.roomID";
$result = $conn->query($sql_select);

// Check for errors in the SELECT query
if (!$result) {
    echo "Error selecting record: " . $conn->error;
} if (mysqli_num_rows($result) >0) {
    
    echo "<table>";
    echo "<tr><th>Faculty Name</th><th>Course Tilte</th><th>Time</th><th>Start Date</th><th>end Date</th><th>room Num</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["FirstName"] . " " . $row["LastName"] . "</td><td>" . $row["Course_Title"] . "</td><td>" . $row["Time"] . "</td><td>" . 
        $row["Start_Date"] . "</td><td>" . $row["End_Date"] . "</td><td>" . $row["Room"] . "</td></tr>";
    }

    echo "</table>";
   
}
else {
    echo "<table>";
    echo "<tr><th>No Class Found</th></tr>";
    
    echo "</table>";
}
}
else
{
header("Location: login.php");
}
?>