<!DOCTYPE html>
<html>
<head>
    <title>Student Home Page</title>    
    <link rel="stylesheet" href="nav_style.css"/>
</head>
<body>
    <h1>Student Home Page</h1>
    
    <ul class="nav">
        <li>
            <a href="student_home.php">Home</a>
        </li>
    
        <li class="dropdown">
            <a href="#" class="drop_button">My Info</a>

            <div class="drop_content">
                <a href="view_schedule.php">View Schedule</a> 
                <a href="#">Add Classes</a>     
            </div> 
        </li>

        <li class="dropdown">        
            <a href="#" class="drop_button">Contact Advisor</a>

        </li>
    </ul>
</body>
</html>