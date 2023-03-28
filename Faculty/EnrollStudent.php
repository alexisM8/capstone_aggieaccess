<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }?>
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
</html>