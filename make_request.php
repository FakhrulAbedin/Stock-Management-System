<?php
session_start();
include("database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_name = $_POST['equipment_name'];
    $requested_quantity = $_POST['requested_quantity'];
    $room_no = $_POST['room_no'];  

    
    $request_id = uniqid();

    // Creating a new request
    $sql_request = "INSERT INTO request (Request_ID, stud_fac_ID, Quantity, Status, Request_date, Room_no, Equipment_name) VALUES (?, ?, ?, 'Pending', NOW(), ?, ?)";
    $stmt = $conn->prepare($sql_request);
    $stmt->bind_param("sisss", $request_id, $user_id, $requested_quantity, $room_no, $equipment_name);
    $stmt->execute();

    $message = "Your Request has been submitted successfully!!"; 
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            color: #333;
            text-align: center;
            padding: 20px;
            animation: fadeInPage 1.5s ease;
        }
        @keyframes fadeInPage {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        header {
            background: #007BFF;
            color: white;
            padding: 20px 0;
            font-size: 24px;
            font-weight: bold;
            animation: fadeInDown 2s ease;
        }
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
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
        select, input[type="text"], input[type="number"], button {
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
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php if (isset($message)) { ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>
    <h2>Make a Request</h2>
    <form action="make_request.php" method="POST">
        <label for="equipment_name">Equipment Name:</label>
        <input type="text" id="equipment_name" name="equipment_name" required>
        <label for="requested_quantity">Requested Quantity:</label>
        <input type="number" name="requested_quantity" id="requested_quantity" required>
        <label for="room_no">Room Number:</label>
        <input type="text" name="room_no" id="room_no" required>
        <button type="submit">Submit Request</button>
    </form>
    <a href="home.php" class="back-button">Back to Home</a>
</body>
</html>
