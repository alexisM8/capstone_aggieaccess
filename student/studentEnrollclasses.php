<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
$student_user = $_SESSION['user_type'];
$login_check = $_SESSION['loggedin'];
if (($_SESSION['user_type'] === 'student')) {
    // removed
} else {
    header("Location: login.php");
}

// Check if the PIN form has been submitted
if (isset($_POST['submit_pin'])) {
    $entered_pin = $_POST['pin'];
    $stored_pin = isset($_COOKIE['pin']) ? $_COOKIE['pin'] : '';

    if ($entered_pin === $stored_pin) {
        $_SESSION['pin_verified'] = true;
    } else {
        $_SESSION['pin_verified'] = false;
        echo 'Incorrect PIN. Please try again.';
    }
}

// Wrap the content in a new if statement checking if the PIN has been verified
if (isset($_SESSION['pin_verified']) && $_SESSION['pin_verified'] === true) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Enroll Classes</title>
</head>
<body>
    <h1>Enroll Classes</h1>
    <form action ="" method="POST">
    <label>Filter by Department</label>
        <?php
        $sql = "SELECT departmentAbbrv FROM department";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<select name='department_abbriviation'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["departmentAbbrv"] . "'>" . $row["departmentAbbrv"] . "</option>";
            }
            echo "</select>";
        } else {
            echo "No results found.";
        }
        ?>
        <input type="submit" name="submit_classes" value="findClasses">
    </form>
    <?php
    if(isset($_POST['submit_classes'])){
        $departmentAbbrv = $_POST['department_abbriviation'];
        $sql = "SELECT DISTINCT cl.classID AS CLID, f.fid AS FID, c.courseTitle AS Course_Title,
        f.lname AS Instructor,        
        t.timerange AS Time,        
        d.days AS Meeting_Days,        
        dt.startDate AS Start_Date,        
        dt.endDate AS End_Date,        
        r.roomNum AS Room 
            FROM course AS c INNER JOIN class AS cl ON c.courseID = cl.courseID  
            INNER JOIN faculty AS f ON cl.profID = f.fid 
            INNER JOIN time AS t ON cl.timeID = t.timeID 
            INNER JOIN day AS d ON cl.dayID = d.daysID 
            INNER JOIN date AS dt ON cl.dateID = dt.dateID 
            INNER JOIN location AS l ON cl.locationID = l.locationID 
            INNER JOIN rooms AS r ON l.roomID = r.roomID
            INNER JOIN department on c.departmentID = department.departmentID
            WHERE department.departmentAbbrv = '$departmentAbbrv'";
                
            $result = mysqli_query($conn, $sql);

            // Check if there are any results
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // Create a table to display the results
                    echo "<table>";
                    echo "<tr>
                            <th>Action</th>
                            <th>Course Name</th>
                            <th>Course Instructor</th>
                            <th>Course Time</th>
                            <th>Meeting Days</th>
                            <th>Session Start</th>
                            <th>Session End</th>
                            <th>Room Number</th>
                        </tr>";
                    // Loop through the results and display them in the table
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>
                                    <form method='POST'>
                                        <input type='hidden' name='classID' value='" . $row['CLID'] . "'>
                                        <input type='hidden' name='facultyID' value='". $row['FID'] . "'>
                                        <input type='hidden' name='className' value='". $row['Course_Title'] . "'>
                                        <button type='submit' name='enroll' value='enroll'>Enroll</button>
                                    </form>
                                </td>
                                <td>" . $row["Course_Title"] . "</td>
                                <td>"  . $row["Instructor"] ."</td>
                                <td>"  . $row["Time"] ."</td>
                                <td>"  . $row["Meeting_Days"] ."</td>
                                <td>"  . $row["Start_Date"] ."</td>
                                <td>"  . $row["End_Date"] ."</td>
                                <td>"  . $row["Room"] ."</td>
                            </tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "No classes found for specified department";
                }
            } else {
                // display error message if query execution failed
                echo 'Error executing query: ' . mysqli_error($conn);
            }
    }
    ?>
    </body>
    </html>
    <?php
    } else {
        // Display the form to input the PIN
        echo '<form action="" method="POST">';
        echo '<label for="pin">Enter PIN:</label>';
        echo '<input type="text" id="pin" name="pin" required>';
        echo '<input type="submit" name="submit_pin" value="Submit PIN">';
        echo '</form>';
    }
    ?>