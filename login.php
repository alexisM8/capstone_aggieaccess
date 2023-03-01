<?php
    require_once 'creds.php';

    echo 'this is a test';

    $conn = new mysqli($host, $user, $pass, $dbname);
    
    if($conn->connect_error){
        echo 'in if conn->error';
        die("Fatal Error");
    }
    $query = "select * from student";
    $result = $conn->query($query);
    if(!$result){
        die("Fatal Error at query");
    }

    $rows = $result->num_rows;

    for($j = 0; $j < $rows; ++$j){
        $result->data_seek($j);
        echo 'sid: '.htmlspecialchars($result->fetch_assoc()['sid']).'<br>';
        echo 'first name: '.htmlspecialchars($result->fetch_assoc()['fname']).'<br>';
        echo 'last name: '.htmlspecialchars($result->fetch_assoc()['lname']).'<br>';
        echo 'email: '.htmlspecialchars($result->fetch_assoc()['email']).'<br>';
        echo 'major: '.htmlspecialchars($result->fetch_assoc()['major']).'<br>';
        echo 'classification: '.htmlspecialchars($result->fetch_assoc()['classification']) . '<br>';
    }

    $result->close();
    $conn->close();
    
?>
