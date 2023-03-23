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
    if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='student'))
  {
    $query = "SELECT c.courseTitle AS Course_Title,
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
            <th>Instrcutor</th> 
            <th>Meeting Time</th>
            <th>Meeting Days</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Room Number</th>';
    
    foreach($rows as $row){
        echo'<tr>
                <td><button onclick="removeRow(this)">Remove</button></td> 
                <td>'.$row['Course_Title'].'</td> 
                <td>'.$row['Instructor'].'</td> 
                <td>'.$row['Time'].'</td> 
                <td>'.$row['Meeting_Days'].'</td> 
                <td>'.$row['Start_Date'].'</td> 
                <td>'.$row['End_Date'].'</td> 
                <td>'.$row['Room'].'</td> 
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
  header("Location: login.php");
}
?>
