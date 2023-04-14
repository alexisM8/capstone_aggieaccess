<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if($conn->connect_error){
    die("Fatal Error");
}

$message = '';

if(isset($_POST['submit'])){
    $email = $_POST['email'];

    // Check if the email exists in the student or faculty table
    $query = "SELECT * FROM student WHERE email = ? UNION SELECT * FROM faculty WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $updated = false;

        while ($row = $result->fetch_assoc()) {
            if(isset($row['sid'])){
                // It's a student
                $passID = "s" . $row['sid'];
                $update_query = "UPDATE student_passwords SET password = ? WHERE passID = ?";
            } else {
                // It's a faculty
                $passID = "f" . $row['fid'];
                $update_query = "UPDATE faculty_passwords SET password = ? WHERE passID = ?";
            }

            $new_pass = "Cameron2023";
            $new_password = $new_pass; // You should generate a random password here
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param('ss', $new_password, $passID);

            if ($stmt->execute()) {
                $updated = true;
            }
        }

        $message = $updated ? "Your password has been reset. Please check your email." : "Error updating password: " . $stmt->error;
    } else {
        $message = "Email not found.";
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
    color: white;
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
    background-color: #009688;
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
    background-color: #008e80;
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
        <input type="submit" name="submit" value="Submit">
        <div>
            <p>Click <a href="login.php">here</a> to login.</p>
        </div>
    </form>
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>