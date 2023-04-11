<?php
  require_once 'creds.php';

  $conn = new mysqli($host, $user, $pass, $dbname, $port);
  
  if($conn->connect_error){
      die("Fatal Error");
  }
  session_start();
  if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='chair')){
    //removed
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Class</title>
</head>
<body>
    <h1>Add Class</h1>
    <form  method="POST">
    <label>Filter by Department</label>
    <button>    
        <input type="submit" name="submit_advisor" vlaue="findAdvisors">
    </form>
    
</body>
</html>