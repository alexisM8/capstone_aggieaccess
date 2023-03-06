<?php
    require_once 'creds.php'; // Require the file that contains the database credentials

    // Establish a connection to the database
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){ // Check if the connection was successful
        die("Fatal Error"); // Terminate the script if there was an error
    }
    
    if(isset($_POST['submit'])){ // Check if the login form was submitted

        $email = $_POST['email']; // Get the email from the form
        $password = $_POST['password']; // Get the password from the form
        
        // Verify user credentials
        if ($email == "admin@example.com" && $password == "admin123") { // If the user is an admin
            // Redirect to the admin page
            header("Location: admin.php");
            exit;
        } else if ($_POST['user_type'] == "student") { // If the user is a student
            // Construct the SQL query to select the student's information
            $sql = "SELECT s.sid, s.fname, s.lname FROM student s, student_passwords sp WHERE s.email = '$email' AND sp.password = '$password' AND s.sid = sp.studentID";
            $redirect = "student.html"; // Set the redirect page to the student dashboard
        } else if ($_POST['user_type'] == "faculty") { // If the user is a faculty member
            // Construct the SQL query to select the faculty member's information
            $sql = "SELECT f.fid, f.fname, f.lname FROM faculty f, faculty_passwords fp WHERE f.email = '$email' AND fp.password = '$password' AND f.fid = fp.facultyID";
            $redirect = "faculty.html"; // Set the redirect page to the faculty dashboard
        }
        
        // Execute the SQL query
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1){ // If there is only one result
            // Start a session and store the user's information in session variables
            session_start();
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['sid'] ?? $row['fid'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['user_type'] = $_POST['user_type'];
            // Redirect the user to the appropriate dashboard
            header("Location: $redirect");
            exit;
        } else {
            $error_msg = "Invalid credentials. Please try again."; // Set an error message if the login was unsuccessful
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type" required>
            <option value="">Select user type</option>
            <option value="faculty">Faculty</option>
            <option value="student">Student</option>
        </select>

        <?php if(isset($error_msg)){ ?>
            <p class="error"><?php echo $error_msg; ?></p>   <!-- Display the error message if there was an error -->
        <?php } ?>

        <input type="submit" name="submit" value="Login">

        
        <div class="forgot-password">
            <p>Don't remember your password?
			<a href="forgot_password.html"> Forgot Password?</a>
            </p>
		</div>
        
    </form>
</body>
</html>
