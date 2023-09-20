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
    $role = $_POST['role']; // Retrieve the role from the form

    // Get the current date
    $currentDate = date("Y-m-d");

    // Check if a record with the same email and current date exists
    $checkQuery = "SELECT id FROM students WHERE email = ? AND registration_date = ?";
    $checkStmt = $mysqli->prepare($checkQuery);
    $checkStmt->bind_param("ss", $email, $currentDate);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo <<<EOL
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'You have already registered Already. Duplicate registrations are not allowed.',
        });
    });
</script>
EOL;
    } else {
        $codeid = rand(10000, 99999);

        // Insert student details into the students table, including the role and registration date
        $insertQuery = "INSERT INTO students (name, course, phone_number, email, role, codeid, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("sssssis", $name, $course, $phone_number, $email, $role, $codeid, $currentDate);

        if ($stmt->execute()) {
            echo <<<EOL
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration successful',
                            text: 'You are now a member of OIC-Hub'
                        }).then(() => {
                            window.location.href = 'register_student.php';
                        });
                    });
                </script>
                EOL;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $mysqli->close();
}
?>
