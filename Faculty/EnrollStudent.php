<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }?>
    <!--Style tag-->
    <style> 

    </style>
    <!--End of Style tag-->
<!DOCTYPE html>
<html>

<form method="post" action="EnrollStudent.php">
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

    <input type="submit" value="Submit">
</form>

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
