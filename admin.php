<?php
$mysqli = new mysqli("localhost", "root", "", "oichub");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT students.id, students.name, students.course, students.phone_number, students.email, attendance.date_signed, TIME_FORMAT(attendance.time, '%H:%i:%s') AS sign_in_time
          FROM students
          INNER JOIN attendance ON students.id = attendance.student_id
          ORDER BY attendance.date_signed DESC";

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    echo "<h1>Student Sign-In Details</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Course</th><th>Email</th><th>Phone Number</th><th>Date Signed</th><th>Sign-In Time</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["course"] . "</td>";
        echo "<td>" . $row["email"] . "</td>"; 
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["date_signed"] . "</td>";
        echo "<td>" . $row["sign_in_time"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No student sign-in records found.";
}

$mysqli->close();
?>
