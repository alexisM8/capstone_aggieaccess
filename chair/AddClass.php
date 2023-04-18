<?php
require_once 'creds.php';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Fatal Error");
}
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Class</title>
    <style>
        form {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            align-items: center;
        }

        label {
            margin-right: 5px;
        }

        .submit-btn-container {
            grid-column: 1 / -1;
        }

        input[type="submit"] {
            width: 100%;
        }
    </style>
</head>
<body>
<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['user_type'] === 'faculty'): ?>
    <form action="?page=AddClass" method="POST">
        <label for="professor">Select Professor:</label>
        <select id="professor" name="professor">
        <?php
        // Fetch faculty from the database
        $sql_faculty = "SELECT * FROM faculty";
        $faculty_result = $conn->query($sql_faculty);
        if ($faculty_result->num_rows > 0) {
            while ($faculty = $faculty_result->fetch_assoc()) {
                $faculty_name = "{$faculty['fname']} {$faculty['lname']}";
                echo "<option value='{$faculty['fid']}'>$faculty_name</option>";
            }
        }
?>
        </select>

        <label for="course">Select Course:</label>
        <select id="course" name="course">
        <?php
        // Fetch courses from the database
        $sql_courses = "SELECT * FROM course";
        $courses_result = $conn->query($sql_courses);
        if ($courses_result->num_rows > 0) {
            while ($course = $courses_result->fetch_assoc()) {
                echo "<option value='{$course['courseID']}'>{$course['courseTitle']}</option>";
            }
        }
        ?>

        </select>
        <label for="location">Select Location:</label>
        <select id="locaton" name="location">
        <?php
        // Fetch locations from the database
        $sql_locations = "SELECT location.locationID, building.buildAbbrv, rooms.roomNum
                        FROM location
                        JOIN building ON location.buildID = building.buildID
                        JOIN rooms ON location.roomID = rooms.roomID";
        $locations_result = $conn->query($sql_locations);
        if ($locations_result->num_rows > 0) {
            while ($location = $locations_result->fetch_assoc()) {
                $display_location = "{$location['buildAbbrv']} - {$location['roomNum']}";
                echo "<option value='{$location['locationID']}'>$display_location</option>";
            }
        }
        ?>



        </select>

        <label for="time">Select Class Time:</label>
        <select id="time" name="time">
        <?php
        // Fetch times from the database
        $sql_times = "SELECT * FROM time";
        $times_result = $conn->query($sql_times);
        if ($times_result->num_rows > 0) {
            while ($time = $times_result->fetch_assoc()) {
                echo "<option value='{$time['timeID']}'>{$time['timeRange']}</option>";
            }
        }
        ?>

        </select>

        <label for="days">Select Days:</label>
        <select id="days" name="days">
        <?php
        // Fetch days from the database
        $sql_days = "SELECT * FROM day";
        $days_result = $conn->query($sql_days);
        if ($days_result->num_rows > 0) {
            while ($day = $days_result->fetch_assoc()) {
                echo "<option value='{$day['daysID']}'>{$day['days']}</option>";
            }
        }
        ?>

        </select>

        <label for="seats">Seat Limit:</label>
        <select id="seats" name="seats">
        <?php
        // Generate seat limits up to 30
        for ($i = 1; $i <= 30; $i++) {
            $selected = ($i == 30) ? 'selected' : '';
            echo "<option value='{$i}' {$selected}>{$i}</option>";
        }
        ?>

        </select>
        <label for="dates">Available Dates:</label>
        <select id="dates" name="date">
        <?php
        // Fetch dates from the database
        $sql_dates = "SELECT * FROM date";
        $dates_result = $conn->query($sql_dates);
        if ($dates_result->num_rows > 0) {
            while ($date = $dates_result->fetch_assoc()) {
                $formatted_date = "{$date['startDate']} - {$date['endDate']}";
                echo "<option value='{$date['dateID']}'>{$formatted_date}</option>";
            }
        }
        ?>
        </select>
        <div class="submit-btn-container">
        <input type="submit" name="submit" value="Add Class">
        </div>
    </form>
    <?php
        if (isset($_POST['submit'])) {
            $profID = $_POST['professor'];
            $courseID = $_POST['course'];
            $locationID = $_POST['location'];
            $timeID = $_POST['time'];
            $dayID = $_POST['days'];
            $seatLimit = $_POST['seats'];
            $dateID = $_POST['date'];

            // Insert the new class into the database
            $sql_insert = "INSERT INTO class (profID, courseID, locationID, timeID, dayID, seatLimit, dateID) VALUES ('$profID', '$courseID', '$locationID', '$timeID', '$dayID', '$seatLimit', '$dateID')";

            if ($conn->query($sql_insert) === TRUE) {
                echo "New class added successfully";
            } else {
                echo "Error adding class: " . $conn->error;
            }
        }
?>
    <?php else: ?>
        <?php header("Location: login.php"); ?>
    <?php endif; ?>
</body>
</html>

