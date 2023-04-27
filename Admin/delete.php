<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }?>
<!DOCTYPE html>
<html>
<style>
    /* Style for body and h1 tags */
body {
    background-color: #f2f2f2;
    font-family: Arial, sans-serif;
    margin: 0;
    background-repeat: no-repeat;
    background-position: center center;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;

}

h1 {
    color: #000000;
    text-align: center;
    margin-top: 100px;
}

/* Style for form */
form {
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
    margin: 20px auto;
    max-width: 500px;
    padding: 20px;
}

/* Style for form labels */
form label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-top: 10px;
}

/* Style for form inputs */
form input[type="text"], form input[type="email"], form input[type="password"], form select {
    border: none;
    border-radius: 2px;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
    padding: 10px;
    width: 100%;
}

form input[type="submit"] {
    background-color: #000000;
    border: none;
    border-radius: 2px;
    color: #ffffff;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
    padding: 10px;
    width: 100%;
}

form input[type="submit"]:hover {
    background-color:#FEC52E;
	color: #000000;
}

/* Style for form message */
form p {
    font-size: 14px;
    margin-top: 20px;
    text-align: center;
}

/* Style for user type options */
#user_type {
    margin-top: 20px;
}
</style>
<head>
	<title>Delete</title>
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


