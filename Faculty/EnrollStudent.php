<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");

    }
    if (isset($_POST['submit'])) {
        $department = $_POST['department'];
    
        // Query to select all classes in a department
        $sql = "SELECT course.courseTitle, course.CRN, faculty.lname, time.timeRange, date.startDate, date.endDate, rooms.roomNum, building.buildAbbrv
                FROM course 
                JOIN class ON course.courseID = class.courseID 
                JOIN time ON class.timeID = time.timeID 
                JOIN date ON class.dateID = date.dateID 
                JOIN location ON class.locationID = location.locationID 
                JOIN rooms ON location.roomID = rooms.roomID
                JOIN building ON location.buildID = building.buildID
                JOIN faculty ON class.profID = faculty.fid
                JOIN department ON department.departmentID = course.departmentID
                WHERE department.departmentAbbrv = '$department'";
    
        $result = $conn->query($sql);
    }
    ?>

    }?>
    <!--Style tag-->
    <style> 

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

    if(isset($_POST['submit'])){

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
// Display table of classes in the selected department
if (isset($result) && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Course Title</th><th>CRN</th><th>Professor</th><th>Time</th><th>Start Date</th><th>End Date</th><th>Room Number</th><th>Building</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["courseTitle"] . "</td><td>" . $row["CRN"] . "</td><td>" . $row["lname"] . "</td><td>" . $row["timeRange"] . "</td><td>" . $row["startDate"] . "</td><td>" . $row["endDate"] . "</td><td>" . $row["roomNum"] . "</td><td>" . $row["buildAbbrv"] . "</td></tr>";
    }

    echo "</table>";
}
?>
</html>


<br>
<?php echo " <strong>Information For Chosen Classes: </strong>" ?>
<table>
    <br>
    <tr>
    <th>Action</th>
            <th>Course Title</th>
            <th>Instructor</th> 
            <th>Meeting Time</th>
            <th>Meeting Days</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Room Number</th>
            <!--submit button must have a value of the queries to show the value of those queries  
            to display in the table -->
            <!--fetch associated rows of the queries and display the info of the queries -->
    </tr>

</table>
</html>


    <input type="submit" value="Submit">
</form>
</html>

