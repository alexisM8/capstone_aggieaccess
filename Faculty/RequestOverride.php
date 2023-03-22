<?php
require_once 'creds.php';
$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
if ((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) && ($_SESSION['user_type'] === 'faculty')) {
    echo '<p>*Students can enroll in a course if the number of students register in the course is equal to or less than <span style="color:red">available seat</span> however then faculty need to send request to chair*</p>';
    echo '<form method="POST" action="?page=RequestOverride">';
    echo '<label>Choose Course</label>';
    $sql = "SELECT *
FROM class AS c
JOIN course AS co ON c.courseID = co.courseID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<select name='your_select_name'>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["courseTitle"] . "'>" . $row["courseTitle"] . "</option>";
        }
        echo "</select>";


    } else {
        echo "No results found.";
    }
    echo '<br><br>';
    echo '<input type="submit" name="check_students" value="ChecK Number of student">';
    echo '</form>';

    if (isset($_POST['check_students'])) {
        $selected_value = $_POST['your_select_name'];
        $sql_select = "SELECT *
    FROM enrollment 
    JOIN student ON enrollment.studentID = student.sid 
    JOIN class ON enrollment.classID = class.classID
    JOIN time ON class.timeID = time.timeID
    JOIN course ON course.courseID = class.courseID
    WHERE course.courseTitle = '$selected_value'";
        $result1 = $conn->query($sql_select);
        if (!$result1) {
            echo "Error selecting record: " . $conn->error;
        }
        $rowCount = $result1->num_rows;
        if (isset($_COOKIE['count'])) {
            $count = $_COOKIE['count'];
        }
        if ($rowCount > $count) {
            echo " </br>";
            echo "<span style=\"color:red\">****************************************Faculty Not Enroll A student Becuase Seat are not avaialable****************************************</span>";
            echo " </br>";
            echo " </br>";
            echo "<button>"."Send Increase a Seat request to Chair upto ".($rowCount)."</button>";
            setcookie("newcount",($rowCount) ,time() + 60 * 60* 60* 24, "/");
            

        } else {
            echo " </br>";
            echo "<span style=\"color:green\">****************************************Faculty Enroll A student ****************************************</span>";
            echo " </br>";
            echo "<span style=\"color:green\">****************************************Goto Enroll a student Page Becuase Seat are not avaialable****************************************</span>";
        }
    }
    $conn->close();
} else {
    header("Location: login.php");
}
?>