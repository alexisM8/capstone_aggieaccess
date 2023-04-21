
<?php
  require_once 'creds.php';

  $conn = new mysqli($host, $user, $pass, $dbname, $port);
  
  if($conn->connect_error){
      die("Fatal Error");
  }
  session_start();
  if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
    
  } else
   {
    header("Location: login.php");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Grant Override</title>
    </head>
    <body>
        <h1>Grant Override</h1>
        <label>Pending Overrides</label>
            <?php
            //select all pending overrides 
            $override_sql = "SELECT student.sid, student.fname, student.lname, faculty.lname AS flname,
            faculty.fid, class.classID, course.courseTitle,class.seatLimit FROM student
            INNER JOIN pending_override on student.sid = pending_override.studentID
            INNER JOIN faculty on faculty.fid = pending_override.facultyID
            INNER JOIN class on class.classID = pending_override.classID
            INNER JOIN course on course.courseID = class.courseID";


            //run the query 
            $override_result = $conn->query($override_sql);


            //if there is at least one pending override 
            if ($override_result->num_rows > 0) 
            {
            echo "<table>";
                echo "<tr>
                        <th>Action</th>
                        <th>Student Name</th>
                        <th>Faculty Name </th>
                        <th>Class</th>
                        <th>Current Seat Limit</th>
                        </tr>";
                // Loop through the pending overrides and  and display them in the table
                while($row = $override_result->fetch_assoc()) 
                { 
                    //do an inner join instead 
                    // //get the student name
                    // $getName_sql = 'SELECT fname FROM student where SID == $row["studentID"]';
                    // $nameResult = $conn->query($getName_sql);

                    echo "<tr>
                            <td>
                                <form method='post' action='?page=GrantOverride' class='rmv_btn'>
                                    <input type='hidden' name='class' value='" . $row['classID'] . "'>
                                    <input type='hidden' name='faculty' value='". $row['fid'] . "'>
                                    <input type='hidden' name='student' value='". $row['sid'] . "'>
                                    <button type='submit' name='enroll' value='submit'>Enroll</button>
                                </form>
                            </td>

                            <td>".$row['fname']." ". $row['lname']."</td>
                            <td> ".$row['flname']."</td>
                            <td>".$row['courseTitle']."</td>
                            <td>".$row['seatLimit']."</td>
                        </tr>";
                }
                //when someone clicks the enroll button
                if(isset($_POST['enroll']) && isset($_POST['class']) && isset($_POST['faculty']) && isset($_POST['student']))
                {
                    $studentID = $_POST['student'];
                    $facultyID = $_POST['faculty'];
                    $classID = $_POST['class'];

                    echo"<html><script>console.log('studentID: ".$studentID."')</script></html>";
                    echo"<html><script>console.log('facultyID: ".$facultyID."')</script></html>";
                    echo"<html><script>console.log('classID: ".$classID."')</script></html>";

                    //check if the student is alreayd enrolled 
                    $sql_check_enrollment = "SELECT * FROM enrollment WHERE classID = '$classID' AND facultyID = '$facultyID' AND studentID = '$studentID'";
                    $result_check_enrollment = mysqli_query($conn, $sql_check_enrollment);

                    //if the student is not already enrolled 
                    if(mysqli_num_rows($result_check_enrollment) == 0)
                    {
                        //enroll the student
                        $sql_enroll = "INSERT INTO enrollment (studentID, facultyID, classID) VALUES ('$studentID', '$facultyID', '$classID')";

                        //verify enrollment success
                        if ($conn->query($sql_enroll) === TRUE) 
                        {
                            $sql_removeOverride1 =  "DELETE FROM pending_override WHERE classID = '$classID' AND studentID = '$studentID' AND facultyID = '$facultyID'";
                            $removeOverride1_results =  mysqli_query($conn, $sql_removeOverride1);

                            if ($removeOverride1_results === TRUE) 
                            {
                                echo"<html><script>location.reload()</script></html>";
                                echo 'Enrollment successful!';
                                //echo 'Successfuly Removed: ';
                            }else{
                                echo 'Failed to Remove: ';
                            }
                        } 
                        //if enrollment fails 
                        else 
                        {
                            echo 'Enrollment failed!';
                        }
                    } 
                    //If student is already entrolled 
                    else 
                    {
                        echo 'Already Enrolled in course I will remove them from here<br>' ;
                        $sql_removeOverride =  "DELETE FROM pending_override WHERE classID = '$classID' AND studentID = '$studentID' AND facultyID = '$facultyID'";
                        if ($conn->query($sql_removeOverride) === TRUE) 
                        {
                            echo 'Successfuly Removed: ';
                        } 
                        else 
                        {
                            echo 'Failed to Remove: ';
                        }
                    }
                }
                
            }
            //if there are no pending overrides 
            else 
            {
                echo "No Pending Overrides.";
            }
            
            ?>
    </body>
    </html>