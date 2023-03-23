<?php //Start of PHP 
    require_once 'creds.php'; // require the file that contains the database credentials

//Establish a connection to the mySQL database
    $conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check to see if there is a connection
    if($conn->connect_error){ 
        die("Fatal Error"); // kill the connection if there was an error
    }

//Retrieve the CS student's and instructor columns from the database
    $query = "SELECT s.fname AS first_name, s.lname AS last_name, f.lname AS advisor
    FROM student s JOIN faculty f ON s.advisorID = f.fid";

//execute the SQL query
    $result = mysqli_query($conn, $query);

    if(!$result){ // If the query fails to execute
        die("Fatal Error at query"); // Error at the query 
    }   

//TODO Create a Contact Form for communication 
/* either do it with html or php for the contact form */

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
    th{
        border:2px solid;
        width: 5px 20px;
        text-align: center;
    } 

    td{
        text-align: left;
        border:2px solid;
        width: 5px 20px;
    }
    ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    li{
        float: left;
    }
    .navbar{
        display:block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .navbar:hover{
        background-color: #111;
        color: white;
    }
    /*styling for the sign */
/* .sign{
        text-align: right;
        color: white;
    } */

</style>
<!--End of Style tag-->

<!--Body of the Secretary Page -->
<body>
    <h1>Secretary Page</h1>
        <ul>
            <div>
            <li class = "navbar"> Home </li> 
            <li class = "navbar student">Student Contact</li> 
            <li class = "navbar advisor">Advisor Contact</li> 
            <li class= "navbar sign" style=" float:right"> Sign Out</li> 
            </div>
        </ul>

    <h2>Information</h2>
    <table>
        <tr>
            <th>Students</th>
            <th>Advisors</th>
        </tr>
        <!--display the queries in tables-->
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr> 
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['advisor'];?> </td>
        </tr>
      
        <?php }?>
    </table>
</body>
</html>
<!--End of HTML -->



