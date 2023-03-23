
<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    $student_id = $_SESSION['id'];
    $student_user = $_SESSION['user_type'];
    $login_check=$_SESSION['loggedin'];
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='student'))
  {
// Define the SQL query
$sql = "SELECT f.email ,s.fname,s.lname
        FROM student AS s
        JOIN faculty AS f ON s.advisorID = f.fid
        WHERE s.sid = '$student_id'";
    $result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($connection));
}

// Process the result
if (mysqli_num_rows($result) > 0) {
    
    echo "<h1>Email of Advisor</h1>";
    
    
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      echo "<h2> please contact on this Email :<a href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a></h2>";
    }
    
    
  } else {
    echo "<table>";
    echo "<tr><th>No results found</th></tr>";
    echo "</table>";
  }
}
else
{
  header("Location: login.php");
}
?>