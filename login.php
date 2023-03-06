<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    
    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        
        // Verify user credentials
        if ($user_type == "student") {
            $sql = "SELECT s.sid, s.fname, s.lname FROM student s, student_passwords sp WHERE s.email = '$email' AND sp.password = '$password' AND s.sid = sp.studentID";
            $redirect = "student.html";
        } else if ($user_type == "faculty") {
            $sql = "SELECT f.fid, f.fname, f.lname FROM faculty f, faculty_passwords fp WHERE f.email = '$email' AND fp.password = '$password' AND f.fid = fp.facultyID";
            $redirect = "faculty.html";
        }
        
        // Execute SQL query
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1){
            // Start session and redirect user to dashboard
            session_start();
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['sid'] ?? $row['fid'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['user_type'] = $user_type;
            header("Location: $redirect");
            exit;
        } else {
            $error_msg = "Invalid credentials. Please try again.";
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
            <p class="error"><?php echo $error_msg; ?></p>
        <?php } ?>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
