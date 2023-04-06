
<?php
  require_once 'creds.php';

  $conn = new mysqli($host, $user, $pass, $dbname, $port);
  
  if($conn->connect_error){
      die("Fatal Error");
  }
  session_start();
  if((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) &&($_SESSION['user_type']==='faculty')){
    //removed
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>List Advisors</title>
</head>
<body>
    <h1>List Advisors</h1>
    <form  method="POST">
    <label>Filter by Department</label>
        <?php
        $sql = "SELECT departmentAbbrv FROM department";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<select name='department_abbriviation'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["departmentAbbrv"] . "'>" . $row["departmentAbbrv"] . "</option>";
            }
            echo "</select>";
        } else {
            echo "No results found.";
        }
        ?>
        <input type="submit" name="submit_advisor" vlaue="findAdvisors">
    </form>
    <?php
    if(isset($_POST['submit_advisor'])){
      $departmentAbbrv = $_POST['department_abbriviation'];
      $sql = "select fname, lname, email
        from faculty f join department d on f.departmentID = d.departmentID
        where d.departmentAbbrv = '$departmentAbbrv'";
              
      $result = mysqli_query($conn, $sql);

      // Check if there are any results
      if ($result) {
          if (mysqli_num_rows($result) > 0) {
              // Create a table to display the results
              echo "<table>";
              echo "<tr>
                      <th>Advisor Name</th>
                      <th>Advisor Email</th>
                  </tr>";
              // Loop through the results and display them in the table
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>".$row["fname"]." ".$row['lname']."</td>
                          <td>".$row["email"]."</td>
                      </tr>";
              }
              echo "</table>";
          } else {
              echo "No Advisors found for specified department";
          }
      } else {
          // display error message if query execution failed
          echo 'Error executing query: ' . mysqli_error($conn);
      }
    }
    ?>
</body>
</html>