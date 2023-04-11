
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) 
{
    die("Fatal Error");
}

session_start();
  if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty'))
  {
    echo '<html>';
        echo '
        <form method="POST">

        <label for="course_Title">Enter Course Title:</label>
        <input type="text" id="course_Title" name="course_Title">

        <label for="crn">Enter Course Reference Number (CRN):</label>
        <input type="text" id="crn" name="crn">

        <label for="deptID">Enter Department ID:</label>
        <input type="text" id="deptID" name="deptID">

        <input type="submit" name="submit" value="Create Course">
        </form>';
            //once submit is clicked
            if(isset($_POST['submit']))
            {
                $course_title = $_POST['course_Title'];
                $crn_num = $_POST['crn'];
                $dept_ID = $_POST['deptID'];

                // Define the SQL query
                $sql_insert = "INSERT into course (courseTitle,CRN,departmentID)
                VALUES('$course_title',$crn_num,$dept_ID)";


                // check if all fields are filled in first 
                if ($course_title && $crn_num &&$dept_ID) 
                {
                   
                    //check if the course title already exists
                    $sql_check_title = "SELECT COUNT(courseTitle) from course where courseTitle='$course_title'";            
                    $name_results = $conn -> query($sql_check_title);
                    $name_exist = $name_results->fetch_assoc(); //this is an associative array 


                    //check if the course CRN already exists
                    $sql_check_crn = "SELECT COUNT(CRN) from course where CRN='$crn_num'";            
                    $crn_results = $conn -> query($sql_check_crn);
                    $crn_exist = $crn_results->fetch_assoc(); //this is an associative array 
 
                    //If that course title is already used 
                    if ($name_exist['COUNT(courseTitle)'] > 0)
                    {
                    echo "<table>";
                    echo "<tr><th>Course Title Already Exists. Try Again.</th></tr>";
                    echo "</table>";   
                    }
                    //If that course CRN is already used 
                    else if ($crn_exist['COUNT(CRN)'] > 0)
                    {    
                        echo "<table>";
                        echo "<tr><th>Course CRN Already Exists. Try Again.</th></tr>";
                        echo "</table>"; 
                    }
                    //If the course title or CRN is NOT already used
                    else
                    {
                        if ($conn->query($sql_insert) === TRUE) 
                        {
                            echo "<table>";
                            echo "<tr><th>Course Successfully Added</th></tr>";
                            echo "</table>";        
                        } 
                        else 
                        {
                            echo "<table>";
                            echo "<tr><th>Course Insert Failed </th></tr>";
                            echo "</table>";          
                         }
                    }
                }
                //if all fields not filled in    
                else
                {
                echo "<table>";
                echo "<tr><th>Enter Course Information. Fill in all fields.</th></tr>";
                echo "</table>";
                }

            }//end if submit button clicked 

        else //if submit button not clicked yet
        {
            echo "<table>";
            echo "<tr><th> Enter Course Information.</th></tr>";
            echo "</table>";
        }
    }
    else
    {
    header("Location: login.php");
    }

    ?>