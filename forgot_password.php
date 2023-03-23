<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if($conn->connect_error){
    die("Fatal Error");
}
if(isset($_POST['submit'])){
$email = $_POST['email'];
$to = "admin@gmail.com";
$subject = "Change password";
$message = "Please reset my password";
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
mail($to, $subject, $message, $headers);
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
        <input type="submit" value="Submit">
        <div>
			<p>Click <a href="login.php">here</a> to login.</p>
		</div>
    </form>
</body>
</html>