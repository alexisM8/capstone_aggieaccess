
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
  die("Fatal Error");
}
session_start();
$student_id = $_SESSION['id'];
$student_user = $_SESSION['user_type'];
$login_check=$_SESSION['loggedin'];
if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='student'))
  {
// Define the SQL query
$sql = "SELECT s.email ,s.fname,s.lname
        FROM student AS s
        WHERE s.sid = '$student_id'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($connection));
}

// Process the result
if (mysqli_num_rows($result) > 0) {

  echo "<h1>Pin Create on student Email:</h1>";


  // Output data of each row
  while ($row = mysqli_fetch_assoc($result)) {
    $email = $row['email']; // replace with the actual email address
    $pin = substr(md5($email . time()), 0, 6); // generate a 6-digit PIN based on the email and current timestamp
    echo "<h1>" . $pin . "</h1>";
    setcookie("pin", $pin, time() + 60 * 60 * 24, "/");
    // set the cookie with the PIN and a 24-hour expiry time
    echo '<button onclick="copyToClipboard(\'' . $pin . '\')">Copy text</button>';

    // JavaScript function to copy the text to the clipboard
    echo '<script>
  function copyToClipboard(text) {
  var dummy = document.createElement("textarea");
  document.body.appendChild(dummy);
  dummy.value = text;
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);

}

</script>';
  


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