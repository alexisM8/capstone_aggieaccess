<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");

    }
    session_start();
    $student_user = $_SESSION['user_type'];
    $login_check=$_SESSION['loggedin'];

    if(isset($_POST['enroll']) && isset($_POST['classID']) && isset($_POST['facultyID']) && isset($_POST['className']) && isset($_POST['studentID'])){
        $studentID = $_POST['studentID'];
        $facultyID = $_POST['facultyID'];
        $classID = $_POST['classID'];
        $courseName = $_POST['className'];
        $sql_check_enrollment = "SELECT * FROM enrollment WHERE classID = '$classID' AND facultyID = '$facultyID' AND studentID = '$studentID'";
        $result_check_enrollment = mysqli_query($conn, $sql_check_enrollment);
        if(mysqli_num_rows($result_check_enrollment) == 0){
            $sql_check_students_enrolled = "SELECT count(enrollment.studentID) as numOfStudentsEnrolled 
            from enrollment where classID = '$classID'";
            $result_check_students_enrolled = ($conn->query($sql_check_students_enrolled))->fetch_assoc();
            $studentsEnrolled = $result_check_students_enrolled['numOfStudentsEnrolled'];
            echo "<html><script>console.log('studenst enrolled: ".$studentsEnrolled."')</script></html>";

            $sql_check_seat_availible = "SELECT seatLimit FROM class WHERE classID = '$classID'";
            $result_check_seat_availible = ($conn->query($sql_check_seat_availible))->fetch_assoc();
            $seatLimit = $result_check_seat_availible['seatLimit'];
            echo "<html><script>console.log('seats availible: ".$seatLimit."')</script></html>";

            $sql_request_override = "INSERT INTO pending_override (studentID, facultyID, classID, oldSeatLimit)
                                     VALUES('$studentID','$facultyID', '$classID', '$seatLimit')";

            if($studentsEnrolled < $seatLimit){
                echo "<html><script>console.log('in studentenrolled < seatLimit')</script></html>";
                $sql_enroll = "INSERT INTO enrollment (studentID, facultyID, classID) VALUES ('$studentID', '$facultyID', '$classID')";
                if ($conn->query($sql_enroll) === TRUE) {
                    echo 'Enrollment successful!';
                } else {
                    echo 'Enrollment failed!';
                }
            }else{
                ?>
                <form method="POST" action="?page=EnrollStudent">
                <lable>Class seat limit reached<br>Request override from Department Chair?<br><br></lable>
                <input type='hidden' name='request_classID' value='$classID'>
                <input type='hidden' name='request_facultyID' value='$facultyID'>
                <input type='hidden' name='request_studentID' value='$studentID'>
                <input type='hidden' name='request_seatLimitID' value='$seatLimit'>
                <input type="radio" name="confrim_override" value='yes'>yes</input><br><br>
                <button type="submit" name="send_request" value='submit'>Send</button>
                </form>
                <?php 
                
            }
            
        }else{
            echo 'Already Enrolled in: ' . $courseName;
        }
    }
    ?>

    <!--Style tag-->
    <style>     
        .enroll_form {
            border: none; 
            padding: 0px;
        }

        button {
            margin: 0px;
            text-align: center;
        }
    </style>
    <!--End of Style tag-->

<!DOCTYPE html>
<html>
<form method="post" action="?page=EnrollStudent">
    <label>Choose Student Email</label>
    <?php
    $sql2 = "SELECT * FROM student";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        echo "<select name='student_id'>";
        while ($row = $result2->fetch_assoc()) {
            echo "<option value='" . $row["sid"] . "'>" . $row["email"] . "</option>";
        }
        echo "</select>";
    }
    ?>

    <br><br>

    <label>Choose Department</label>
    <select name="department">
        <?php
        $result = mysqli_query($conn, "SELECT departmentAbbrv FROM department");

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['departmentAbbrv'] . '">' . $row['departmentAbbrv'] . '</option>';
        }
        ?>
    </select>

    <br><br>

    <input name = "submit" type="submit" value="Submit">
</form>
<?php
if(isset($_POST['send_request']) && isset($_POST['request_classID']) && isset($_POST['request_studentID']) && isset($_POST['request_facultyID']) && isset($_POST['request_seatLimit'])){
    $ans = $_POST['confrim_override'];
    $studentID = $_POST['request_studentID'];
    $facultyID = $_POST['request_facultyID'];
    $classID = $_POST['request_classID'];
    $seatLimit = $_POST['request_seatLimit'];
    $sql_request_override = "INSERT INTO pending_override (studentID, facultyID, classID, oldSeatLimit)
                            VALUES('$studentID','$facultyID', '$classID', '$seatLimit')";
                            ?>
    <html><script>console.log('ans: ".$ans."')</script></html>
    <?php
    if ($ans == 'yes' && $conn->query($sql_request_override) === TRUE) {
        echo 'Enrollment override requested!';
    } else {
        echo 'Error: Enrollment override request failed!';
    }
} 
 if (isset($_POST['submit'])) {
    $department = $_POST['department'];
    $studentID = $_POST['student_id'];

    // Query to select all classes in a department
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
        WHERE department.departmentAbbrv = '$department'";

    $result = mysqli_query($conn, $sql);
    
    // Display table of classes in the selected department
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
                        <form method='POST' class='enroll_form'>
                            <input type='hidden' name='studentID' value='" . $studentID . "'>
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
</html>
