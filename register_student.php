<?php
// require 'database/db.php';
require 'registration/student.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/access.css">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Including SweetAlert2 CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="body">

   <div class="wrapper">
   <div class="form-box login">
   <span class="bg-animate"></span>
     

   <form action="register_student.php" method="POST">
        <div class="input-box">
        <input type="text" id="name" name="name" required><br><br>
        <label for="name">Name:</label>
        <i class="fa-solid fa-user"></i>

        </div>
        <div class="input-box">
        <input type="text" id="course" name="course" required><br><br>
        <label for="course">Course:</label>
        <i class="fa-solid fa-book"></i>

    </div>
        <div class="input-box">
        <input type="text" id="phone_number" name="phone_number" required><br><br>
        <label for="phone_number">Phone Number:</label>  
        <i class="fa-solid fa-phone"></i>

    </div>

        <div class="input-box">
        <input type="email" id="email" name="email" required><br><br>
        <label for="email">Email:</label> 
        <i class="fa-solid fa-envelope"></i>

    </div>

        <div class="form-group" style="margin-top:20px">
        <!-- Add the role field -->
        <label for="role" style="color:white;font-weight:400">Role:</label>
        <select id="role" name="role">
            <option value="student">Student</option>
            <option value="tutor">Tutor</option>
        </select>
        </div>
    <span class="b-animate"></span>
        <button  type="submit" class="btn" style="color:white;font-weight:800">Register</button>

        <!-- <input class="btn" value="Register"> -->
    </form>
    
   </div>
   <div class="info-text login" id="block">
            <h2>Please Register</h2>
            <p>
                Select Your Role To Be Able to Sign Attendance
            </p>
    </div>
   </div>

</body>
</html>
