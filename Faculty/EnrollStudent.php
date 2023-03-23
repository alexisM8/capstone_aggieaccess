<?php
require_once 'creds.php';
$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
if ((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) && ($_SESSION['user_type'] === 'faculty')) {
    echo '<form method="POST" action="?page=EnrollStudent">';
    echo '<label>Choose Class</label>';
    $sql = "SELECT * FROM class join course ON class.courseID=course.courseID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<select name='your_select_name'>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["classID"] . "'>" . "Class " . $row["courseTitle"] . "</option>";
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
        while ($row = $result1->fetch_assoc()) {
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
        while ($row = $result2->fetch_assoc()) {
            echo "<option value='" . $row["sid"] . "'>" . $row["email"] . "</option>";
        }
        echo "</select>";
    } else {
        echo "No results found.";
    }
    echo '<br><br>';
    echo '<input type="submit" name="submit" value="Enroll Student">';
    echo '</form>';

    if (isset($_POST['submit'])) {

        $selected_value = $_POST['your_select_name'];
        $sql_select = "SELECT *
    FROM enrollment 
    JOIN student ON enrollment.studentID = student.sid 
    JOIN class ON enrollment.classID = class.classID
    JOIN time ON class.timeID = time.timeID
    JOIN course ON course.courseID = class.courseID
    WHERE class.classID = '$selected_value'";
        $result4 = $conn->query($sql_select);
        if (!$result4) {
            echo "Error selecting record: " . $conn->error;
        }
        $rowCount = $result4->num_rows;
        if (isset($_COOKIE['count'])) {
            $count = $_COOKIE['count'];
        }
        if ($rowCount > $count) {
            echo " </br>";
            echo "<span style=\"color:red\">****************************************Faculty Not Enroll A student Becuase Seat are not avaialable****************************************</span>";
            echo " </br>";
            echo " </br>";
            echo '<script>
            function copyToClipboard() {
                window.location.href = "?page=RequestOverride";
          
          }
          
          </script>';
          echo '<button onclick="copyToClipboard()">Go to Request Override</button>';

        } else {
            echo "<span style=\"color:green\">****************************************Student are enrolled****************************************</span>";
            $selected_value1 = $_POST['your_select_name1'];
            $selected_value2 = $_POST['your_select_name2'];
            $sql_select = "INSERT INTO enrollment(studentID, facultyID, classID)
            VALUES ('$selected_value2','$selected_value1', '$selected_value')";
            $result3 = $conn->query($sql_select);
            if (!$result3) {
                echo "Error: " . $sql_select . "<br>" . $conn->error;
            } else {

            }
        }

    }

    $conn->close();
} else {
    header("Location: login.php");
}
?>