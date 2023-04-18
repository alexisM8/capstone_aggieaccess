<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
    echo '<html>';
    echo '
    <form action="chair.php?page=studentschedule" method="POST">
    <label for="email">Enter Student Email:</label>
    <input type="email" id="email" name="email">
    <input type="submit" name="submit" value="Search">
    </form>';
    if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $query = "SELECT cl.classID AS CLID, 
            f.fid AS FID,
            c.courseTitle AS Course_Title,
            f.lname AS Instructor,        
            t.timerange AS Time,        
            d.days AS Meeting_Days,        
            dt.startDate AS Start_Date,        
            dt.endDate AS End_Date,        
            r.roomNum AS Room,
            b.buildAbbrv AS Build_Abbrv
        FROM course AS c INNER JOIN class AS cl ON c.courseID = cl.courseID 
        INNER JOIN enrollment AS e ON cl.classID = e.classID 
        INNER JOIN student AS s ON e.studentID = s.sid
        INNER JOIN enrollment AS z ON cl.classID = z.classID AND z.studentID = s.sid
        INNER JOIN faculty AS f ON z.facultyID = f.fid 
        INNER JOIN time AS t ON cl.timeID = t.timeID 
        INNER JOIN day AS d ON cl.dayID = d.daysID 
        INNER JOIN date AS dt ON cl.dateID = dt.dateID 
        INNER JOIN location AS l ON cl.locationID = l.locationID 
        INNER JOIN building AS b ON l.buildID = b.buildID
        INNER JOIN rooms AS r ON l.roomID = r.roomID
        WHERE s.email = '$email'";
        
    $result = $conn->query($query);
    if(!$result){
        die("Fatal Error at query");
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
    
    if (mysqli_num_rows($result) >0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    echo '<html>';
    
    echo 
    '<table>
        <tr>
            <th>Action</th>
            <th>Course Title</th>
            <th>Instrcutor</th> 
            <th>Meeting Time</th>
            <th>Meeting Days</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Room Number</th>
            <th>Building Abbrv.</td>';
    
    foreach($rows as $row){
        echo'<tr>
                <td>
                    <form class="rmv_btn" method="POST">
                        <input type="hidden" name="classID" value="'.$row["CLID"].'">
                        <input type="hidden" name="facultyID" value="'.$row["FID"].'">
                        <input type="hidden" name="className" value="'.$row["Course_Title"].'">
                        <button type="submit" name="remove" value="remove">Remove</button>
                    </form>
                </td> 
                <td>'.$row['Course_Title'].'</td> 
                <td>'.$row['Instructor'].'</td> 
                <td>'.$row['Time'].'</td> 
                <td>'.$row['Meeting_Days'].'</td> 
                <td>'.$row['Start_Date'].'</td> 
                <td>'.$row['End_Date'].'</td> 
                <td>'.$row['Room'].'</td> 
                <td>'.$row['Build_Abbrv'].'</td>
            </tr>';
        echo '<br>';
    }
    echo'</table>';
    echo'<button class="print_btn" onclick="window.print()">Print Schedule</button>';
    echo '</html>';
    $result->close();
    $conn->close();
}
else
{
    echo "<table>";
    echo "<tr><th>Student Not Enroll Any Course</th></tr>";
    
    echo "</table>";
}
}
else
{
    echo "<table>";
    echo "<tr><th>Please Enter Student Id</th></tr>";
    
    echo "</table>";
}
}
else
{
header("Location: login.php");
}
?>

