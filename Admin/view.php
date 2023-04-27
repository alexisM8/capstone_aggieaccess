<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
?>
<!DOCTYPE html>
<html>
<style>
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

}

h1 {
    color:  #000000;
    text-align: center;
    margin-top: 100px;
}
</style>
<head>
    <title>View Users</title>
</head>
<body>
    <h1>All Users</h1>

    <h2 id="ahead">Students</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Classification</th>
                <th>Major</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "                
            select s.sid, s.fname, s.lname, s.email, s.phone, s.classification, m.majorAbbrv
            from student s join major m on s.majorID = m.majorID");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['sid'] . "</td>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['lname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['classification'] . "</td>";
                echo "<td>" . $row['majorAbbrv'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Faculty</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Office Number</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql_faculty = "SELECT f.fid, f.fname, f.lname, f.email, fr.roles, b.buildAbbrv, r.roomNum, f.phone FROM faculty f JOIN faculty_roles fr ON f.role = fr.frid JOIN location l ON f.office = l.locationID JOIN building b ON l.buildID = b.buildID JOIN rooms r ON l.roomID = r.roomID;";
        $result = mysqli_query($conn, $sql_faculty);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['fid'] . "</td>";
            echo "<td>" . $row['fname'] . "</td>";
            echo "<td>" . $row['lname'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['roles'] . "</td>";
            echo "<td>" . $row['buildAbbrv'] . " " . $row['roomNum'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
    </table>

    <?php
    mysqli_close($conn);
    ?>
</body>
</html>