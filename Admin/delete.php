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
    <link rel="stylesheet" href="signup_page.css">
</head>
<body>
	<h1>Delete User</h1>
	<form action="delete.php" method="POST">

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
                    

                    $sql_enrollment = "delete from enrollment where studentID in (select sid from student where email = '$email')";
                    // Insert password into "student_passwords" table
                    $sql_password = "delete from student_passwords where studentID in (select sid from student where email = '$email')";
                    $sql_student="delete from student where sid in (select sid from student where email = '$email')";
                    if (mysqli_query($conn, $sql_enrollment)) {
                        if(mysqli_query($conn, $sql_password)){
                            if(mysqli_query($conn, $sql_student))
                            {
                                
                                
                                echo "User created successfully";
                            }
                            else{
                                echo "Error creating user: " . mysqli_error($conn);
                            }
                        }else{
                            echo "Error creating user: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error creating user: " . mysqli_error($conn);
                    }
                } else if ($user_type == "faculty") {
                    $sql = "delete from faculty where fid in (select fid from faculty where email = '$email')";
                    // Insert password into "faculty_passwords" table
                    $sql_password = "delete from faculty_passwords where facultyID in (select fid from faculty where email = '$email')";
                    if (mysqli_query($conn, $sql)) {
                        if(mysqli_query($conn, $sql_password)){
                           echo "User created successfully";
                        }else{
                            echo "Error creating user: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error creating user: " . mysqli_error($conn);
                    }
                }

                // Execute SQL query
                

                // Close database connection
                mysqli_close($conn);
            }

            ?>
        <input name = "submit" type="submit" value="Add User">
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

</html>
