<script type="text/javascript" src="remove_button.js"></script>

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
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) && ($_SESSION['user_type']==='student')){
        
    $query = "SELECT cl.classID AS CLID, 
            f.fid AS FID,
            c.courseTitle AS Course_Title,
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
        WHERE s.sid = '$student_id'";
     
    $sql = "SELECT s.email ,s.fname,s.lname,s.classification,s.phone, m.major
            FROM student s join major m on s.majorID = m.majorID
            WHERE s.sid = '$student_id'";

    $result = mysqli_query($conn, $sql);   
    
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }
    if(isset($_POST['remove']) && isset($_POST['classID']) && isset($_POST['facultyID']) && isset($_POST['className'])){
        $studentID = $_SESSION['id'];
        $facultyID = $_POST['facultyID'];
        $classID = $_POST['classID'];
        $courseName = $_POST['className'];
        $sql_check_enrollment = "SELECT * FROM enrollment WHERE classID = '$classID' AND facultyID = '$facultyID' AND studentID = '$studentID'";
        $result_check_enrollment = mysqli_query($conn, $sql_check_enrollment);
        if(mysqli_num_rows($result_check_enrollment) >= 1){
            $sql_remove = "DELETE FROM enrollment WHERE classID = '$classID' AND studentID = '$studentID' AND facultyID = '$facultyID'";
            if ($conn->query($sql_remove) === TRUE) {
                echo 'Successfuly Removed: '.$courseName.'!';
            } else {
                echo 'Failed to Remove: '.$courseName.'!';
            }
        } else {
            echo 'Not Enrolled in: ' . $courseName;
        }
    }

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        $row = mysqli_fetch_assoc($result);
        echo "<h1>Schedule</h1>";
        echo "<table>";
        echo "<tr><th>First Name</th><th>Last Name</th><th>Student Name</th></tr>";
        echo "<tr><td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td><td>" . $row["email"] . "</td></tr>";
        echo "</table>";
        echo "<table>";
        echo "<tr><th>Major</th><th>Classification</th><th>Phone Number</th></tr>";
        echo "<tr><td>" . $row["major"] . "</td><td>" . $row["classification"] . "</td><td>" . $row["phone"] . "</td></tr>";
        echo "</table>";  
    } else {
        echo "<table>";
        echo "<tr><th>No results found</th></tr>";
        echo "</table>";
      }

    $result = $conn->query($query);
    if(!$result){
        die("Fatal Error at query");
    }

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    
    echo '<html>';
   
    echo 
    '<table>
        <tr>
            <th>Action</th>
            <th>Course Title</th>
            <th>Instructor</th> 
            <th>Meeting Time</th>
            <th>Meeting Days</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Room Number</th>
        </tr>';
    
    foreach($rows as $row){
        echo"<tr>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='classID' value='".$row['CLID']."'>
                        <input type='hidden' name='facultyID' value='".$row['FID']."'>
                        <input type='hidden' name='className' value='".$row['Course_Title']."'>
                        <button type='submit' name='remove' value='remove'>Remove</button>
                    </form>
                </td> 
                <td>".$row['Course_Title']."</td> 
                <td>".$row['Instructor']."</td> 
                <td>".$row['Time']."</td> 
                <td>".$row['Meeting_Days']."</td> 
                <td>".$row['Start_Date']."</td> 
                <td>".$row['End_Date']."</td> 
                <td>".$row['Room']."</td> 
            </tr>";
        echo '</br>';
    }
    echo'</table>';
    echo'<button class="print_btn" onclick="window.print()">Print Schedule</button>';
    echo '</html>';
    $result->close();
    $conn->close();
}
else
{
  header("Location: login.php");
}
?>