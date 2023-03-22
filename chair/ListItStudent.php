
<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
    // Replace the student email with the desired student's email

// Prepare the SQL statement
$sql = "SELECT student.fname, student.lname, student.email,student.major 
        FROM   student
        WHERE student.major = 'IT'";

// Execute the SQL statement and get the result
$result = mysqli_query($conn, $sql);

// Check if there are any results
if ($result) {
if (mysqli_num_rows($result) >0) {

    // Create a table to display the results
    echo "<h1 style='text-align: center; color: black;'>"."IT Student List"."</h1>";
    echo "<table>";
    echo "<tr><th>Student Name</th><th>Student Email</th><th>Student Department</th></tr>";

    // Loop through the results and display them in the table
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["fname"] . " " . $row["lname"] . "</td><td>" . $row["email"] . "</td><td>" . $row["major"] . "</td></tr>";
    }

    echo "</table>";

} else {
    echo "<table>";
    echo "<tr><th>No Student Found in IT department.</th></tr>";
    
    echo "</table>";
}
}
else {
    // display error message if query execution failed
    echo 'Error executing query: ' . mysqli_error($conn);
}

// Close the database connection
$conn->close();
}
else
{
header("Location: login.php");
}
?>