<?php
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            max-height: 80vh; 
            overflow-y: auto; 
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"], select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #007bbf;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #007bbf;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            text-align: center;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
            animation: fadeInBounce 2s ease;
        }
        @keyframes fadeInBounce {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
    <script>
        function toggleFields() {
            const role = document.querySelector('select[name="role"]').value;
            document.getElementById('student-fields').style.display = (role === 'student') ? 'block' : 'none';
            document.getElementById('faculty-fields').style.display = (role === 'faculty') ? 'block' : 'none';
            document.getElementById('admin-fields').style.display = (role === 'administration') ? 'block' : 'none';
            document.getElementById('staff-fields').style.display = (role === 'staff') ? 'block' : 'none';
        }
         
        window.onload = function() {
            toggleFields();
        }
    </script>
</head>
<body>
    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/4/40/BRAC_University_monogram.svg/640px-BRAC_University_monogram.svg.png" alt="BRAC University Logo" class="logo">
    <div class="form-container">
    <h2>Registration Form</h2>
    <form action="register.php" method="POST">
        <label>ID:</label>
        <input type="text" name="uni_id" placeholder="Enter your ID" required><br>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter your Name" required><br>
        <label>Contact:</label>
        <input type="text" name="contact" placeholder="Enter your Contact Number" required><br>
        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter your Email" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter your Password" required><br>
        <label>Role:</label>
        <select name="role" onchange="toggleFields()" required>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
            <option value="administration">Administration</option>
            <option value="staff">Staff</option>
        </select><br>

       
        <div id="student-fields" style="display: none;">
            <label>Department:</label>
            <input type="text" name="course" placeholder="Enter your Department"><br>
        </div>

        
        <div id="faculty-fields" style="display: none;">
            <label>Department:</label>
            <input type="text" name="department" placeholder="Enter Department"><br>
            <label>Designation:</label>
            <input type="text" name="designation" placeholder="Enter Designation"><br>
        </div>

        <button type="submit">Register</button>
    </form>
    <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>    
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = $_POST['uni_id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Inserting into user table
    $sql_user = "INSERT INTO user (ID , Name, Contact_no, Email, Password) VALUES ('$id', '$name', '$contact', '$email', '$password')";
    if ($conn->query($sql_user) === TRUE) {
        // Inserting into role-specific table
        switch ($role) {
            case 'student':
                $id = $_POST['uni_id'];
                $course = $_POST['course'];
                $sql_student = "INSERT INTO student (Student_ID, Department) VALUES ($id, '$course')";
                if ($conn->query($sql_student) !== TRUE) {
                    echo "Error updating student table: " . $conn->error;
                }
                break;

            case 'faculty':
                $id = $_POST['uni_id'];
                $department = $_POST['department'];
                $designation = $_POST['designation'];
                $sql_faculty = "INSERT INTO faculty (Faculty_ID, Department, Designation) VALUES ($id, '$department', '$designation')";
                if ($conn->query($sql_faculty) !== TRUE) {
                    echo "Error updating faculty table: " . $conn->error;
                }
                break;

            case 'administration':
                $id = $_POST['uni_id'];
                $sql_admin = "INSERT INTO administration (Admin_ID) VALUES ($id)";
                if ($conn->query($sql_admin) !== TRUE) {
                    echo "Error updating administration table: " . $conn->error;
                }
                break;

            case 'staff':
                $id = $_POST['uni_id'];
                $sql_staff = "INSERT INTO staff (Staff_ID) VALUES ($id)";
                if ($conn->query($sql_staff) !== TRUE) {
                    echo "Error updating staff table: " . $conn->error;
                }
                break;

            default:
                echo "Invalid role selected.";
        }
        echo '<div style="position: absolute; top: 20%; right: 10%; color: green; font-size: 18px;">Registration successful!</div>';
        echo '<script>
                setTimeout(() => {
                    window.location.href = "login.php";
                }, 2000); // Redirect after 2 seconds
              </script>';
    } else {
        echo "Error updating user table: " . $conn->error;
    }

    $conn->close();
}
?>
