<style>
    /* Global styles */
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
        background-image: url('loginImage.jpg');

    }

    h1 {
        color: #FEC52E;
        text-shadow: black 1px 1px;
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
    form input[type="text"],
    form input[type="email"],
    form input[type="password"],
    form select {
        border: none;
        border-radius: 2px;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
        padding: 10px;
        width: 100%;
    }

    form input[type="submit"] {
        background-color: black;
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
        background-color: #FEC52E;
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

    /* Style for student and faculty options */
    #student_options,
    #faculty_options {
        margin-top: 20px;
        padding: 10px;
    }

    #student_options label,
    #faculty_options label {
        display: inline-block;
        margin-right: 10px;
    }

    #student_options select,
    #faculty_options select {
        margin-right: 20px;
        width: 120px;
    }

    #major {
        width: 200px;
    }

    #office {
        width: 100px;
    }
</style>
<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
session_destroy();
setcookie('pin', "", time() - 3600,"/");
if (isset($_POST['submit']) && $_POST['email'] == 'admin@gmail.com' && $_POST['password'] == '1234') {
    session_start();
    $_SESSION['email'] = $_POST['email'];
    $redirect = "Admin.php";
    header("Location: $redirect");

} else if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Verify user credentials
    if ($user_type == "student") {
        $sql = "SELECT s.sid, s.fname, s.lname FROM student s, student_passwords sp WHERE s.email = '$email' AND sp.password = '$password' AND s.sid = sp.studentID";
        $redirect = "student.php?page=Home";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Start session and redirect user to dashboard
            session_start();
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['sid'] ?? $row['fid'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['user_type'] = $user_type;
            $_SESSION['loggedin'] = true;
            if ($user_type == "faculty") {
                if ($row['role'] == 1) {
                    $redirect = "faculty.php";
                } else if ($row['role'] == 2) {
                    $redirect = "Secretary.php";
                } else if ($row['role'] == 3) {
                    $redirect = "Chair.php";
                }
            }
            header("Location: $redirect");
            exit;
        } else {
            $error_msg = "Invalid credentials. Please try again.";
        }
    } else if ($user_type == "faculty") {
        $sql = "SELECT f.fid, f.fname, f.lname, f.role FROM faculty f, faculty_passwords fp WHERE f.email = '$email' AND fp.password = '$password' AND f.fid = fp.facultyID";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Start session and redirect user
            session_start();
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['sid'] ?? $row['fid'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['user_type'] = $user_type;
            $_SESSION['loggedin'] = true;
            if ($user_type == "faculty") {
                if ($row['role'] == 1) {
                    $redirect = "faculty.php?page=Home";
                } else if ($row['role'] == 2) {
                    $redirect = "Secretary.php?page=Home";
                } else if ($row['role'] == 3) {
                    $redirect = "Chair.php?page=Home";
                }
            }
            header("Location: $redirect");
            exit;
        } else {
            $error_msg = "Invalid credentials. Please try again.";
        }
    } else {
        $error_msg1 = 'Please Select User type';
        

    }
    // Execute SQL query

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
        <!--Checkbox -->
        <input type="checkbox" onclick="conceal()">Show Password
        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type">
            <option value="">Select User Type</option>
            <option value="faculty">Faculty</option>
            <option value="student">Student</option>
        </select>

        <?php if (isset($error_msg)) { ?>
            <p class="error">
                <?php echo $error_msg; ?>
            </p>
        <?php } ?>
        <?php if (isset($error_msg1)) { ?>
            <p class="error">
                <?php echo $error_msg1; ?>
            </p>
        <?php } ?>

        <input type="submit" name="submit" value="Login">

        <p><a href="forgot_password.php">Forgot Password</a></p>
    </form>
    <script>
    // function to show and hide password  
            function conceal(){
                var x = document.getElementById("password");
                    if(x.type === "password") {
                        x.type = "text";
                    }else{
                            x.type = "password";
                        }
    } </script>
</body>

</html>
