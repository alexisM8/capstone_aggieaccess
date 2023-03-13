<?php
require_once 'creds.php'; // Require the file that contains the database credentials

// Establish a connection to the database
$conn = new mysqli($host, $user, $pass, $dbname, $port);

if($conn->connect_error){ // Check if the connection was successful
    die("Fatal Error"); // Terminate the script if there was an error
}

if(isset($_POST['add_student'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $major = $_POST['major'];
    $classification = $_POST['classification'];
    $phone = $_POST['phone'];
    add_student($conn, $fname, $lname, $email, $major, $classification, $phone);
}

if(isset($_POST['add_faculty'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $office = $_POST['office'];
    $phone = $_POST['phone'];
    add_faculty($conn, $fname, $lname, $email, $role, $office, $phone);
}

// Function to add a new student
function add_student($conn, $fname, $lname, $email, $major, $classification, $phone) {
    $sql = "INSERT INTO student (fname, lname, email, major, classification, phone) 
            VALUES ('$fname', '$lname', '$email', '$major', '$classification', '$phone')";
    
    if(mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
}

// Function to add a new faculty member
function add_faculty($conn, $fname, $lname, $email, $role, $office, $phone) {
    $sql = "INSERT INTO faculty (fname, email, lname, role, office, phone) 
    VALUES ('$fname', '$email', '$lname',
        (SELECT frid FROM faculty_roles WHERE faculty_roles.roles = '$role'),
        (SELECT locationID FROM (SELECT locationID, buildAbbrv, roomNum
                                FROM location JOIN building ON location.buildID = building.buildID
                                    JOIN rooms ON location.roomID = rooms.roomID) AS temp 
                                    WHERE CONCAT(temp.buildAbbrv, temp.roomNUM) = '$office'), '$phone')";
    
    if(mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
   
}




if(isset($_POST['delete_student'])) {
    $sid = $_POST['sid'];
    delete_student($conn, $sid);
}

if(isset($_POST['delete_faculty'])) {
    $fid = $_POST['fid'];
    delete_faculty($conn, $fid);
}

// Function to delete a student
function delete_student($conn, $sid) {
    $sql_delete_enrollment = "DELETE FROM enrollment WHERE studentID = $sid";
    $sql_delete_student_passwords = "DELETE FROM student_passwords WHERE studentID = $sid";
    $sql_delete_student = "DELETE FROM student WHERE sid = $sid";
    
    if(mysqli_query($conn, $sql_delete_enrollment) && mysqli_query($conn, $sql_delete_student_passwords) && mysqli_query($conn, $sql_delete_student)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Function to delete a faculty member
function delete_faculty($conn, $fid) {
    $sql_delete_enrollment = "DELETE FROM enrollment WHERE facultyID = $fid";
    $sql_delete_class = "DELETE FROM class WHERE profID = $fid";
    $sql_delete_faculty_passwords = "DELETE FROM faculty_passwords WHERE facultyID = $fid";
    $sql_delete_faculty = "DELETE FROM faculty WHERE fid = $fid";
    
    if(mysqli_query($conn, $sql_delete_enrollment) && mysqli_query($conn, $sql_delete_class)&& mysqli_query($conn, $sql_delete_faculty_passwords) && mysqli_query($conn, $sql_delete_faculty)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}


// Construct the SQL query to select all the students' information
$sql_students = "SELECT s.sid, s.fname, s.lname, s.email, s.major, s.classification, s.phone FROM student s";
$result_students = mysqli_query($conn, $sql_students);

// Construct the SQL query to select all the faculty members' information
$sql_faculty = "SELECT f.fid, f.fname, f.lname, f.email, f.role FROM faculty f";
$result_faculty = mysqli_query($conn, $sql_faculty);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Add Student</h2>
<form method="post" action="admin.php">
    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" required>

    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    
    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="major">Major:</label>
			<select id="major" name="major">
        <option value="">Select major</option>
        <?php
        // Retrieve data from "department" table
        $result = mysqli_query($conn, "SELECT departmentAbbrv FROM department");

        // Generate "Major" select element options
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['departmentAbbrv'].'">'.$row['departmentAbbrv'].'</option>';
        }
        ?>
    </select>

    <div><label for="classification">Classification:</label>
			<select id="classification" name="classification">
				<option value="">Select classification</option>
				<option value="Freshman">Freshman</option>
				<option value="Sophomore">Sophomore</option>
				<option value="Junior">Junior</option>
				<option value="Senior">Senior</option>
			</select>
    </div>
    <div>
    &nbsp
    </div>
    


    <button type="submit" name="add_student">Add Student</button>
</form>

<h2>Add Faculty</h2>
<form method="post" action="admin.php">
    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" required>

    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="role">Role:</label>
			<select id="role" name="role">
				<option value="">Select role</option>
				<option value="professor">Professor</option>
				<option value="secretary">Secretary</option>
				<option value="chair">Chair</option>
			</select>
    <label for="office">Office:</label>
            <select id="office" name="office">
				<option value="">Select office number</option>
				<?php

                // Retrieve data from "location" table
		        $result = mysqli_query($conn, "SELECT buildAbbrv, roomNum
		        FROM location JOIN building ON location.buildID = building.buildID
		        JOIN rooms ON location.roomID = rooms.roomID where RIGHT(roomNUM, 1) in ('A', 'B', 'C', 'D')");

                // Generate "Office Number" select element options
                while ($row = mysqli_fetch_assoc($result)) {
                 echo '<option value="'.$row['buildAbbrv'].$row['roomNum'].'">'.$row['buildAbbrv'].$row['roomNum'].'</option>';
                }
                ?>
			</select>
    <div>
    &nbsp
    </div>

    <button type="submit" name="add_faculty">Add Faculty</button>
</form>
    <h2>Students</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Major</th>
                <th> &nbsp Classification</th>
                <th>Phone </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result_students)){ ?>
                <tr>
                    <td><?php echo $row['sid']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['major']; ?></td>
                    <td> &nbsp<?php echo $row['classification']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td>
                    <form method="post" action="admin.php">
                            <input type="hidden" name="sid" value="<?php echo $row['sid']; ?>">
                            <button type="submit" name="delete_student" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                    </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


<h2>Faculty</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result_faculty)){ ?>
            <tr>
                <td><?php echo $row['fid']; ?></td>
                <td><?php echo $row['fname']; ?></td>
                <td><?php echo $row['lname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                <form method="post" action="admin.php">
                    <input type="hidden" name="fid" value="<?php echo $row['fid']; ?>">
                    <button type="submit" name="delete_faculty" onclick="return confirm('Are you sure you want to delete this faculty member?')">Delete</button>
                </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this student?");
    }
</script>

</body>
</html> 