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
    $sql = "SELECT f.email, f.fname, f.lname
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
        $row = mysqli_fetch_assoc($result);
        $advisor_name = $row['fname'] . ' ' . $row['lname'];
        $advisor_email = $row['email'];
        
        echo "<style>";
        echo "h1, p {text-align: center;}";
        echo "</style>";
        
        echo "<h1>Advisor Information</h1>";
        echo "<p><strong>Name:</strong> $advisor_name</p>";
        echo "<p><strong>Email:</strong> <a href='mailto:$advisor_email'>$advisor_email</a></p>";
        echo "<br><br>";
        echo "<form method='post' enctype='text/plain'>";
        echo "Subject:<br>";
        echo "<input type='text' name='subject'><br>";
        echo "Message:<br>";
        echo "<textarea name='message' rows='5' cols='50'></textarea><br><br>";
        echo "<input type='submit' value='Send' onclick='alert(\"Message sent successfully!\")'>";
        echo "</form>";
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