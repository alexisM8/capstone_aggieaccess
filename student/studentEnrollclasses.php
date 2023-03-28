<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    $student_user = $_SESSION['user_type'];
    $login_check=$_SESSION['loggedin'];
    if(($_SESSION['user_type']==='student'))
  {
    if(isset($_POST['submit'])){
    if (isset($_COOKIE['pin'])) {
        $username = $_COOKIE['pin'];
        $pin = $_POST['pin'];
        if($username==$pin)
        {
        
        
        if(isset($_POST['submit'])) {
          setcookie('pin', $username, time() - 3600,"/");
          $selected_value = $_POST['your_select_name'];
          $selected_value1 = $_POST['your_select_name1'];
          $selected_value2 = $_SESSION['id'];

          //This code is broken good luck - Rachel + Alexis
          $query4 = "SELECT classID from class JOIN course on course.courseID = class.courseID WHERE course.courseTitle = '$selected_value'";
          $getClassID = $conn->query($query4);
          $row = $getClassID->fetch_assoc();
          $myClass = $row["classID"];
          $sql_select = "INSERT INTO enrollment(studentID, facultyID, classID) VALUES ('$selected_value2','$selected_value1',$myClass)";
          
          $result3 = $conn->query($sql_select);
          if (!$result3) {
              echo "Error: " . $sql_select . "<br>" . $conn->error;
          } else {
              $error_msg = "Student Enrolled";
          }
      }
        
        }
        else
        {
          $error_msg="Wrong pin";
        }
      } else {
        $error_msg="Please request for a pin";
      }
    }
}
else
{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Enroll Classes</title>
</head>
<body>
    <h1>Enroll Classes</h1>
    <form action="?page=studentEnrollclasses" method="POST">
        <label for="pin">Enroll Pin:</label>
        <input type="type" id="pin" name="pin" required>
        <?php
echo '<form method="POST" action="EnrollStudent.php">';
echo '<label>Choose Class</label>';
$sql = "SELECT course.courseTitle FROM course JOIN class ON course.courseID = class.courseID";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<select name='your_select_name'>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["classID"] . "'>" . $row["courseTitle"] . "</option>";
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
?>
<?php if(isset($error_msg)){ ?>
            <p class="error"><?php echo $error_msg; ?></p>
        <?php } ?>
        <input type="submit" name="submit" value="Enroll Class">
    </form>
</body>
</html>