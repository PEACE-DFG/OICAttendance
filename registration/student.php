<?php
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

function connectToDatabase()
{
    $mysqli = new mysqli("localhost", "root", "", "oichub");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    return $mysqli;
}

function checkDuplicateRegistration($email, $currentDate)
{
    $mysqli = connectToDatabase();

    $checkQuery = "SELECT id FROM students WHERE email = ? AND registration_date = ?";
    $checkStmt = $mysqli->prepare($checkQuery);
    $checkStmt->bind_param("ss", $email, $currentDate);
    $checkStmt->execute();
    $checkStmt->store_result();
    $duplicateExists = ($checkStmt->num_rows > 0);

    $checkStmt->close();
    $mysqli->close();

    return $duplicateExists;
}

function insertStudentRecord($name, $course, $phone_number, $email, $role, $codeid, $currentDate)
{
    $mysqli = connectToDatabase();

    $insertQuery = "INSERT INTO students (name, course, phone_number, email, role, codeid, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertQuery);
    $stmt->bind_param("sssssis", $name, $course, $phone_number, $email, $role, $codeid, $currentDate);

    $insertSuccess = $stmt->execute();

    $stmt->close();
    $mysqli->close();

    return $insertSuccess;
}

function sendRegistrationEmail($email, $name, $codeid, &$mail)
{
    // Configure SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'awofesobipeace@gmail.com';
    $mail->Password = 'gbnmkwehbmzlzlth';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Set sender and recipient email addresses
    $mail->setFrom('awofesobipeace@gmail.com', 'OIC-Hub');
    $mail->addAddress($email, $name);

    // Email subject and body
    $mail->isHTML(true);
    $mail->Subject = 'Welcome to OIC-Hub';
    $mail->Body = "Dear $name,<br><br>
                Thank you for registering with OIC-Hub. Your code ID is: $codeid<br><br>
                You can use this code ID for signing your attendance.<br><br>
                Welcome to OIC-Hub!<br><br>
                Best regards,<br>
                Your Name";

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $currentDate = date("Y-m-d");
    $codeid = rand(10000, 99999);

    // Create a PHPMailer object
    $mail = new PHPMailer();

    if (checkDuplicateRegistration($email, $currentDate)) {
        echo <<<EOL
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'You have already registered. Duplicate registrations are not allowed.',
        });
    });
</script>
EOL;
    } else {
        if (insertStudentRecord($name, $course, $phone_number, $email, $role, $codeid, $currentDate)) {
            if (sendRegistrationEmail($email, $name, $codeid, $mail)) {
                echo <<<EOL
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Registration successful',
            text: 'You are now a member of OIC-Hub. Check your email for your code ID.'
        }).then(() => {
            window.location.href = 'register_student.php';
        });
    });
</script>
EOL;
            } else {
                echo <<<EOL
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error sending email: {$mail->ErrorInfo}'
        });
    });
</script>
EOL;
            }
        } else {
            echo "Error: Failed to insert student record.";
        }
    }
}
?>
