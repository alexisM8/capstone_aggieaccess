<?php //Start of PHP 
    require_once 'creds.php'; // require the file that contains the database credentials

//Establish a connection to the mySQL database
    $conn = new mysqli($host, $user, $pass, $dbname, $port);

    if($conn->connect_error){ // Check to see if there is a connection
        die("Fatal Error"); // kill the connection if there was an error
    }

//Retrieve the CS student's and instructor queries from the database
    $sql = "SELECT 'student' AS type, fname, lname, email
            FROM student
            UNION ALL
            SELECT 'faculty' AS type, fname, lname, email
            FROM faculty ";
    $result = $conn->query($sql);

    if(!$result){ // If the query fails kill the connection
        die("Fatal Error at query");
    }   

    //fetch all the 
    $rows = $result->fetch_all(MYSQLI_ASSOC);

//Start of HTML tag
    echo '<html>';

//Start of Style tag
echo'
    <style>

/*Style for the table */
    table{
        border-collapse: collapse; /*takes the double borders away*/
        border: 1px solid black;
        width: 75%;
        
    }

/*Style for the table header */
    th,td{
        border:2px solid;
        width: 5px 20px;
        text-align: left;
    } 

/*Style for the body 
    body{
        background-color: #171A1B;
}*/
    </style>';
//End of Style tag

// Start of Tables 
        //foreach($rows as $row){
    echo
    '<table>
        <tr>
            <th>Students</th>
            <th>Student Contact</th>
            <th>Advisors</th>
            <th>Advisor Contact</th>
        </tr>';

        echo'<tr>
                <td>'.'</td>
            
            </tr>';
    
    //}
   //TODO Create a Contact Form for communication 
//Ending tag of Tables
    echo'</table>';

//End of HTML tag
    echo'</html>';


//END of PHP
?>

