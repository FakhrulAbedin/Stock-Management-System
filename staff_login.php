<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['id'];
    $password = $_POST['password'];

    // Checking user exists and is a staff member
    $sql = "SELECT u.Password, u.Name, s.Staff_ID FROM staff s JOIN user u ON s.Staff_ID = u.ID WHERE s.Staff_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
        
        
        if (password_verify($password, $user['Password'])) {
            $_SESSION['staff_id'] = $user['Staff_ID'];
            $_SESSION['staff_name'] = $user['Name'];
            
            
            header("Location: Staff_home.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No staff member found with that ID.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }
        .logo {
            width: 150px;
            margin: 20px auto;
            animation: fadeInBounce 2s ease;
        }
        @keyframes fadeInBounce {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }
            50% {
                opacity: 0.5;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: left;
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .register-link {
            margin-top: 10px;
        }
        .register-link a {
            color: #007BFF;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<img src="https://upload.wikimedia.org/wikipedia/en/thumb/4/40/BRAC_University_monogram.svg/640px-BRAC_University_monogram.svg.png" alt="BRAC University Logo" class="logo">
    <h2>Staff Login</h2>
    <form action="staff_login.php" method="POST">
        <label>User ID:</label>
        <input type="text" name="id" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        Don't have an account? <a href="register.php">Register here</a>
    </div>
</body>
</html>
