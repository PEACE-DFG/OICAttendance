<?php
$mysqli = new mysqli("localhost", "root", "", "oichub");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT students.name, students.course, students.email, students.phone_number, students.email, students.role, attendance.date_signed, TIME_FORMAT(attendance.time, '%H:%i:%s') AS sign_in_time, students.registration_date
          FROM students
          INNER JOIN attendance ON students.id = attendance.student_id
          ORDER BY attendance.date_signed DESC";

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    echo "<h1>Student Sign-In Details</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Course</th><th>Email</th><th>Phone Number</th><th>Role</th><th>Date Signed</th><th>Sign-In Time</th><th>Date Registered</th></tr>";

    $counter = 1; // Initialize a counter variable

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>"; // Display the sequential number (ID)
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["course"] . "</td>";
        echo "<td>" . $row["email"] . "</td>"; 
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["role"] . "</td>"; // Display the role
        echo "<td>" . $row["date_signed"] . "</td>";
        echo "<td>" . $row["sign_in_time"] . "</td>";
        echo "<td>" . $row["registration_date"] . "</td>"; // Display the registration date
        echo "</tr>";

        $counter++; // Increment the counter for the next student
    }

    echo "</table>";
} else {
    echo "No student sign-in records found.";
}

$mysqli->close();
?>
