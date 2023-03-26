<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
if ((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) && ($_SESSION['user_type'] === 'faculty')) {

    if (isset($_POST['submit'])) {
        $firstname = $_POST['username'];
        $lastname = $_POST['username1'];

        // Define the SQL query
        $sql_select = "SELECT * FROM student WHERE fname='$firstname' and lname='$lastname'";
        $result = $conn->query($sql_select);

        // Check for errors in the SELECT query
        if (!$result) {
            echo "Error selecting record: " . $conn->error;
        } elseif (mysqli_num_rows($result) > 0) {

            while ($row = $result->fetch_assoc()) {
                $to = $row["email"];
                $subject = "Message from " . $_POST['name'];
                $message = $_POST['message'];
                $headers = "From: " . $_SESSION['loggedin'] . "\r\n" .
                    "Reply-To: " . $_POST['email'] . "\r\n" .
                    "X-Mailer: PHP/" . phpversion();

                if (mail($to, $subject, $message, $headers)) {
                    echo "Email sent successfully to " . $row["fname"] . " " . $row["lname"];
                } else {
                    echo "Error sending email.";
                }
            }
        } else {
            echo "No student found with first name: " . $firstname . " and last name: " . $lastname;
        }
    }

    echo '<html>';
    echo '
    <form action="?page=ContactStudent" method="POST">
    <label for="username">Enter Student First Name:</label>
    <input type="text" id="username" name="username">
    <label for="username1">Enter Student Last Name:</label>
    <input type="text" id="username1" name="username1">
    <br><br>
    Your Name:
    <input type="text" name="name"><br><br>
    Email Address:
    <input type="text" name="email"><br><br>
    Message:
    <textarea name="message"></textarea><br><br>
    <input type="submit" name="submit" value="Contact">
    </form>';
} else {
    header("Location: login.php");
}
?>
