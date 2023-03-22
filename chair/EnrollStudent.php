
<?php
require_once 'creds.php';
$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
echo '<form method="POST" action="?page=EnrollStudent">';
echo '<label>Choose Class</label>';
$sql = "SELECT * FROM class";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<select name='your_select_name'>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["classID"] . "'>" ."Class ". $row["classID"] . "</option>";
    }
    echo "</select>";
} else {
    echo "No results found.";
}
echo '<br><br>';
echo '<label>Choose Teacher Email</label>';
$sql1 = "SELECT * FROM faculty";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    echo "<select name='your_select_name1'>";
    while($row = $result1->fetch_assoc()) {
        echo "<option value='" . $row["fid"] . "'>" . $row["email"] . "</option>";
    }
    echo "</select>";
} else {
    echo "No results found.";
}
echo '<br><br>';
echo '<label>Choose Student Email</label>';
$sql2 = "SELECT * FROM student";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    echo "<select name='your_select_name2'>";
    while($row = $result2->fetch_assoc()) {
        echo "<option value='" . $row["sid"] . "'>" . $row["email"] . "</option>";
    }
    echo "</select>";
} else {
    echo "No results found.";
}
echo '<br><br>';
echo '<input type="submit" name="submit" value="Enroll Student">';
echo '</form>';

if(isset($_POST['submit'])) {
   
    $selected_value = $_POST['your_select_name'];
    $selected_value1 = $_POST['your_select_name1'];
    $selected_value2 = $_POST['your_select_name2'];
    $sql_select = "INSERT INTO enrollment(studentID, facultyID, classID)
    VALUES ('$selected_value2','$selected_value1', '$selected_value')";
    $result3 = $conn->query($sql_select);
    if (!$result3) {
        echo "Error: " . $sql_select . "<br>" . $conn->error;
    } else {
        header("Location: ../Chair.html");
    }
}

$conn->close();
}
else
{
header("Location: login.php");
}
?>