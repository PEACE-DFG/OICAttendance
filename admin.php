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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign-In Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        table th {
            background-color: #007BFF;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <h1>Student Sign-In Details</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
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
    ?>

    <?php
    $mysqli->close();
    ?>
</body>
</html>
