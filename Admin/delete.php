<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
	<h1>Delete User</h1>
	<form action="?page=AdminDelete" method="POST">

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>

		<label for="user_type">User Type:</label>
		<select id="user_type" name="user_type" required onchange="displayOptions()">
			<option value="">Select user type</option>
			<option value="faculty">Faculty</option>
			<option value="student">Student</option>
		</select>

		
		
        <?php

            if(isset($_POST['submit'])){
                $user_type = $_POST['user_type'];
                $email = $_POST['email'];
                // Insert user data into appropriate table
                if ($user_type == "student") {
                    //enter pass into student table
                    $sql_enrollment = "DELETE e FROM enrollment e JOIN student s ON e.studentID = s.sid WHERE s.email = '$email'";
                    $sql_password = "DELETE sp FROM student_passwords sp JOIN student s ON sp.studentID = s.sid WHERE s.email = '$email'";
                    $sql_student = "DELETE FROM student WHERE email = '$email'";
                    if (mysqli_query($conn, $sql_enrollment)) {
                        if(mysqli_query($conn, $sql_password)){
                            if(mysqli_query($conn, $sql_student))
                            {
                                echo "User deleted successfully";
                            }
                            else{
                                echo "Error deleting user: " . mysqli_error($conn);
                            }
                        }else{
                            echo "Error deleting user: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error deleting user: " . mysqli_error($conn);
                    }
                } else if ($user_type == "faculty") {
                    //enter pass into fact table
                    $sql = "DELETE fp FROM faculty_passwords fp JOIN faculty f ON fp.facultyID = f.fid WHERE f.email = '$email'";
                    $sql_password = "DELETE FROM faculty WHERE email = '$email'";
                    if (mysqli_query($conn, $sql)) {
                        if(mysqli_query($conn, $sql_password)){
                            echo "User deleted successfully";
                        }else{
                            echo "Error deleting user: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error deleting user: " . mysqli_error($conn);
                    }
                }
                

                // Execute SQL query
                

                // Close database connection
                mysqli_close($conn);
            }

            ?>
        <input name = "submit" type="submit" value="Delete User">
	</form>

	<script>
		function displayOptions() {
			var userType = document.getElementById("user_type").value;
			var studentOptions = document.getElementById("student_options");
			var facultyOptions = document.getElementById("faculty_options");

			if (userType == "student") {
				studentOptions.style.display = "block";
				facultyOptions.style.display = "none";
			} else if (userType == "faculty") {
				facultyOptions.style.display = "block";
				studentOptions.style.display = "none";
			} else {
				studentOptions.style.display = "none";
				facultyOptions.style.display = "none";
			}
		}
	</script>
</body>


