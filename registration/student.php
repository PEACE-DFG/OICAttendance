<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli("localhost", "root", "", "oichub");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $name = $_POST['name'];
    $course = $_POST['course'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email']; 

   
    if (!empty($name) && !empty($course) && !empty($phone_number) && !empty($email)) {
        $codeid = rand(10000, 99999);

        $query = "INSERT INTO students (name, course, phone_number, email, codeid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssssi", $name, $course, $phone_number, $email, $codeid);

        if ($stmt->execute()) {
            echo "Student registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }

    $mysqli->close();
}
?>
