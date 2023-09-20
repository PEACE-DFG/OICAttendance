<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $entered_code = $_POST['code'];

    $mysqli = new mysqli("localhost", "root", "", "oichub");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $code_check_query = "SELECT id FROM students WHERE id = ? AND codeid = ?";
    $code_check_stmt = $mysqli->prepare($code_check_query);
    $code_check_stmt->bind_param("ii", $student_id, $entered_code);
    $code_check_stmt->execute();
    $code_check_stmt->store_result();

    if ($code_check_stmt->num_rows > 0) {
        $today = date("Y-m-d");
        $check_query = "SELECT id, TIME_FORMAT(time, '%H:%i:%s') AS formatted_time FROM attendance WHERE student_id = ? AND date_signed = ?";
        $check_stmt = $mysqli->prepare($check_query);
        $check_stmt->bind_param("is", $student_id, $today);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $check_stmt->bind_result($attendance_id, $sign_in_time);
            $check_stmt->fetch();
            echo <<<EOL
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Attendance Already Signed',
                        text: 'You have already signed in today at $sign_in_time',
                    });
                });
            </script>
        EOL;
        
        } else {
            $insert_query = "INSERT INTO attendance (student_id, date_signed, time) VALUES (?, ?, NOW())";
            $insert_stmt = $mysqli->prepare($insert_query);
            $insert_stmt->bind_param("is", $student_id, $today);

            if ($insert_stmt->execute()) {
                $current_time = date("H:i:s");
                echo <<<EOL
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Attendance Signed Successfully',
                            text: 'Attendance signed successfully at $current_time on $today',
                        });
                    });
                </script>
            EOL;
            
            } else {
                echo "Error: " . $insert_stmt->error;
            }

            $insert_stmt->close();
        }
        $check_stmt->close();
    } else {
        echo <<<EOL
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid code or student selection. Please check and try again.',
                });
            });
        </script>
    EOL;
    
    }

    $code_check_stmt->close();
    $mysqli->close();
}
?>
