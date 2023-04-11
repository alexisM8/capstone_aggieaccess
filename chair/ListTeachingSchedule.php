
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
$f_id=$_SESSION['id'];
$student_id = $_SESSION['id'];
$student_user = $_SESSION['user_type'];
$login_check=$_SESSION['loggedin'];

$sql = "SELECT f.email ,f.fname,f.lname,f.phone
        FROM  faculty AS f
        WHERE f.fid = '$student_id'";

        $result = mysqli_query($conn, $sql);

    // Display the first and last name of the chair
            echo "<b>Your Information:</b>";
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th></tr>";

        $row = mysqli_fetch_assoc($result);
            echo "<tr><td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td></tr>";
            echo "</table>";

    //Display the email and phone number of the chair
            echo "<table>";
            echo "<tr><th>Faculty Email</th><th>Phone Number</th></tr>";
            echo "<tr><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td></tr>";
            echo "</table>";

    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty')){
        echo '
            <form action="?page=ListTeachingSchedule" method="POST">
            <label for="username">Enter Teacher Last name:</label>
            <input type="text" id="username" name="username">
            <input type="submit" name="submit" value="Find Teacher Schedule">
            </form>';

    if(isset($_POST['submit'])){
    $lastname = $_POST['username'];
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
        INNER JOIN faculty AS g ON e.facultyID = g.fid AND g.lname = '$lastname'
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
} 
// Display the taught classes by the professor
if (mysqli_num_rows($result) > 0){    
    echo "<table>";
    echo "<tr><th>Faculty Name</th><th>Course Title</th><th>Time</th><th>Start Date</th><th>End Date</th><th>Room Number</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["FirstName"] . " " . $row["LastName"] . "</td><td>" . $row["Course_Title"] . "</td><td>" . $row["Time"] . "</td><td>" . 
        $row["Start_Date"] . "</td><td>" . $row["End_Date"] . "</td><td>" . $row["Room"] . "</td></tr>";
    }

            echo "</table>";

    }
    // There are no classes taught by that professor
        else { 
            echo "<table>";
            echo "<tr><th>No Teacher Schedule</th></tr>";

            echo "</table>";
            }
    }
                    }
    else{
            header("Location: login.php");
        }
?>