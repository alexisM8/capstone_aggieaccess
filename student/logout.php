<?php
    require_once 'creds.php';

    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if($conn->connect_error){
        die("Fatal Error");
    }
    session_start();
    session_destroy();
    setcookie('pin',"", time() - 3600,"/");
    header("Location: login.php");
?>
