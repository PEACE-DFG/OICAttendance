<?php
require 'attendance/attendance.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Signing</title>
</head>
<body>
    <h1>Attendance Signing</h1>
    <form action="" method="POST">
        <label for="student_id">Select Your Name:</label>
        <select id="student_id" name="student_id" required>
            <?php
            // Connect to the database (replace with your credentials)
            $mysqli = new mysqli("localhost", "root", "", "oichub");

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Query to fetch student names from the database
            $query = "SELECT id, name FROM students";
            $result = $mysqli->query($query);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }

            $mysqli->close();
            ?>
        </select><br><br>

        <label for="code">Enter Your 5-Digit Code:</label>
        <input type="text" id="code" name="code" pattern="[0-9]{5}" required><br><br>

        <input type="submit" value="Sign Attendance">
    </form>
</body>
</html>

