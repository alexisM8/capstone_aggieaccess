<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Sign Up</h1>
	<form action="signup_page.php" method="POST">
		<label for="fname">First Name:</label>
		<input type="text" id="fname" name="fname" required>

		<label for="lname">Last Name:</label>
		<input type="text" id="lname" name="lname" required>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>

		<label for="phone">Phone:</label>
		<input type="text" id="phone" name="phone" required>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required>

		<label for="c_password">Confirm Password:</label>
		<input type="password" id="c_password" name="c_password" required>

		<!-- 
		<p>Remember your login info? <a href="login.php">Login here</a>.</p>
		-->
		
		<label for="user_type">User Type:</label>
		<select id="user_type" name="user_type" required onchange="displayOptions()">
			<option value="">Select user type</option>
			<option value="faculty">Faculty</option>
			<option value="student">Student</option>
		</select>

		<div id="student_options" style="display: none;">
			<label for="classification">Classification:</label>
			<select id="classification" name="classification">
				<option value="">Select classification</option>
				<option value="freshman">Freshman</option>
				<option value="sophomore">Sophomore</option>
				<option value="junior">Junior</option>
				<option value="senior">Senior</option>
			</select>

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

	
		</div>
		
		<div id="faculty_options" style="display: none;">
			<label for="role">Role:</label>
			<select id="role" name="role">
				<option value="">Select role</option>
				<option value="professor">Professor</option>
				<option value="secretary">Secretary</option>
				<option value="chair">Chair</option>
			</select>

			<label for="office">Office Number:</label>
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
		</div>

		
        <?php

            if(isset($_POST['submit'])){
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $password = $_POST['password'];
                $user_type = $_POST['user_type'];
                
                // Insert user data into appropriate table
                if ($user_type == "student") {
                    $classification = $_POST['classification'];
                    $major = $_POST['major'];

                    $sql = "INSERT INTO student (fname, lname, email, phone, classification, major) VALUES ('$fname', '$lname', '$email', '$phone', '$classification', '$major')";
                    // Insert password into "student_passwords" table
                    $sql_password = "INSERT INTO student_passwords (password, studentID) 
                                        VALUES ('$password', (SELECT sid FROM student WHERE student.email = '$email'))";

                } else if ($user_type == "faculty") {
                    $role = $_POST['role'];
                    $office = $_POST['office'];
                    $sql = "INSERT INTO faculty (fname, email, lname, role, office, phone) 
								VALUES ('$fname', '$email', '$lname',
									(SELECT frid FROM faculty_roles WHERE faculty_roles.roles = '$role'),
									(SELECT locationID FROM (SELECT locationID, buildAbbrv, roomNum
															FROM location JOIN building ON location.buildID = building.buildID
																JOIN rooms ON location.roomID = rooms.roomID) AS temp 
																WHERE CONCAT(temp.buildAbbrv, temp.roomNUM) = '$office'), '$phone')";
                    // Insert password into "faculty_passwords" table
                    $sql_password = "INSERT INTO faculty_passwords (password, facultyID)
                                        VALUES('$password', (SELECT fid FROM faculty WHERE faculty.email = '$email'))";
                }

                // Execute SQL query
                if (mysqli_query($conn, $sql)) {
					if(mysqli_query($conn, $sql_password)){
						echo "User created successfully";
					}else{
						echo "Error creating user: " . mysqli_error($conn);
					}
                } else {
                    echo "Error creating user: " . mysqli_error($conn);
                }

                // Close database connection
                mysqli_close($conn);
            }

            ?>
        <input name = "submit" type="submit" value="Submit">
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
