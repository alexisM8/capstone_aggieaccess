<?php //Start of PHP 
    require_once 'creds.php'; // require the file that contains the database credentials

//Establish a connection to the mySQL database
    $conn = new mysqli($host, $user, $pass, $dbname, $port);

    if($conn->connect_error){ // Check to see if there is a connection
        die("Fatal Error"); // kill the connection if there was an error
    }

//Retrieve the CS student's and instructor columns from the database
    $sql = "SELECT 'student' AS type, fname, lname, email
            FROM student
            UNION ALL
            SELECT 'faculty' AS type, fname, lname, email
            FROM faculty ";
    //execute the SQL query
    $result = $conn->query($sql);

    if(!$result){ // If the query fails kill the connection
        die("Fatal Error at query");
    }   

    //fetch all the 
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    //! TODO  Redo the the HTML to the way in the admin page
    //TODO Create a Contact Form for communication 

//END of PHP
?>

<!--Start of HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretary Page</title>
</head>
<!--Start of Style tag-->
<style>
/*Style for the table */
table{
        border-collapse: collapse; /*takes the double borders away*/
        border: 1px solid black; /*border is a thin solid black */
        width: 75%;
        
    }

/*Style for the table header */
    th,td{
        border:2px solid;
        width: 5px 20px;
        text-align: left;
    } 

/*Styling for the body 
    body{
        background-color: #171A1B;
}*/

</style>
<!--End of Style tag-->

<!--Body of the Secretary Page -->
<body>
    <h1>Secretary Page</h1>
    <h2>Information</h2>
    <table>
        <tr>
            <th>Students</th>
            <th>Student Contact</th>
            <th>Advisors</th>
            <th>Advisor Contact</th>
        </tr>
    </table>
</body>
</html>
<!--End of HTML -->



