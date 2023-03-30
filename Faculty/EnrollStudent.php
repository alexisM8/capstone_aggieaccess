<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");

    }
    session_start();
    $student_user = $_SESSION['user_type'];
    $login_check=$_SESSION['loggedin'];

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
        echo "<select name='student_email'>";
        while ($row = $result2->fetch_assoc()) {
            echo "<option value='" . $row["email"] . "'>" . $row["email"] . "</option>";
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
 if (isset($_POST['submit'])) {
    $department = $_POST['department'];

    // Query to select all classes in a department
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
                        <form method='POST' class= 'enroll_form'>
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
