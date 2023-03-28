
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
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
// Define the SQL query
$sql = "SELECT f.email ,f.fname,f.lname,f.phone
        FROM  faculty AS f
        WHERE f.fid = '$student_id'";
    $result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// Process the result
if (mysqli_num_rows($result) > 0) {
    
    echo "<table>";
    echo "<tr><th>First Name</th><th>Last Name</th></tr>";
    
    // Output data of each row
    $row = mysqli_fetch_assoc($result);
    echo "<tr><td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td></tr>";
    echo "</table>";
    
    echo "<table>";
    echo "<tr><th>Faculty Email</th><th>Phone Number</th></tr>";
    echo "<tr><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td></tr>";
    echo "</table>";

    
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