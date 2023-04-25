<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if($conn->connect_error){
    die("Fatal Error");
}

$message = '';
$update_query = '';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $new_pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass !== $confirm_pass) {
        $message = '<p style="color:red;">Passwords do not match.</p>';
    } else {
        // Check if the email exists in the student or faculty table
        $query = "SELECT * FROM student WHERE email = '$email' UNION SELECT * FROM faculty WHERE email = '$email'";
        $result = $conn->query($query);

        if($result->num_rows > 0){
            $updated = false;

            while ($row = $result->fetch_assoc()) {
                if(isset($row['sid'])){
                    // It's a student
                    $passID = $row['sid'];
                    $update_query = "UPDATE student_passwords SET password = '$new_pass' WHERE passID = $passID";
                } else {
                    // It's a faculty
                    $passID = $row['fid'];
                    $update_query = "UPDATE faculty_passwords SET password = '$new_pass' WHERE passID = '$passID'";
                }

                if ($conn->query($update_query)) {
                    $updated = true;
                }
            }

            $message = $updated ? '<p>Your password has been reset. Please check your email.</p>' : '<p style="color:red;">Error updating password: ' . $conn->error . '</p>';
        } else {
            $message = '<p style="color:red;">Email not found.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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
form input[type="text"], form input[type="email"], form input[type="password"], form select {
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
    background-color: #FEC52E;;
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
#student_options, #faculty_options {
    margin-top: 20px;
    padding: 10px;
}

#student_options label, #faculty_options label {
    display: inline-block;
    margin-right: 10px;
}

#student_options select, #faculty_options select {
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
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="forgot_password.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <input type="checkbox" onclick="conceal()">Show Password
        <input type="submit" name="submit" value="Submit">  
        
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        
        <div>
            <p>Return to <a href="login.php">login</a></p>
        </div>
    </form>

    <script>
    // function to show and hide password  
    function conceal(){
        var x = document.getElementById("password");
        var y = document.getElementById("confirm_password");
        
        if(x.type === "password" || y.type === "password") {
            x.type = "text";
            y.type = "text";
        } else {
            x.type = "password";
            y.type = "password";
        }
    }
</script>
</body>
</html>