<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    $student_user = $_SESSION['user_type'];
    $login_check=$_SESSION['loggedin'];
    if(($_SESSION['user_type']==='student')){
        //removed
    } else {
        header("Location: login.php");
    }

    if(isset($_POST['enroll']) && isset($_POST['classID']) && isset($_POST['facultyID']) && isset($_POST['className'])){
        $studentID = $_SESSION['id'];
        $facultyID = $_POST['facultyID'];
        $classID = $_POST['classID'];
        $courseName = $_POST['className'];
        $sql_check_enrollment = "SELECT * FROM enrollment WHERE classID = '$classID' AND facultyID = '$facultyID' AND studentID = '$studentID'";
        $result_check_enrollment = mysqli_query($conn, $sql_check_enrollment);
        if(mysqli_num_rows($result_check_enrollment) == 0){
            $sql_enroll = "INSERT INTO enrollment (studentID, facultyID, classID) VALUES ('$studentID', '$facultyID', '$classID')";
            if ($conn->query($sql_enroll) === TRUE) {
                echo 'Enrollment successful!';
            } else {
                echo 'Enrollment failed!';
            }
        } else {
            echo 'Already Enrolled in: ' . $courseName;
        }
    }
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
        <input type="submit" name="submit_classes" vlaue="findClasses">
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
            INNER JOIN enrollment AS e ON cl.classID = e.classID 
            INNER JOIN student AS s ON e.studentID = s.sid
            INNER JOIN enrollment AS z ON cl.classID = z.classID AND z.studentID = s.sid
            INNER JOIN faculty AS f ON z.facultyID = f.fid 
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
                                <td>"  . $row["Start_Date"] ."</td>
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