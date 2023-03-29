
<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
    // Define the SQL query
     $sql = "SELECT DISTINCT f.email ,f.fname,f.lname
        FROM student AS s
        JOIN faculty AS f ON s.advisorID = f.fid";
    $result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($connection));
}

// Process the result
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Advisor Name</th><th>Advisor Email</th></tr>";
    
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr><td>" . $row["fname"] . " " . $row["lname"] . "</td><td>" . $row["email"] . "</td></tr>";
    }
    
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