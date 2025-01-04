<?php
session_start();
include("database.php");

// Checking that admin or staff is logging in or not
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_name = $_POST['equipment_name'];
    $category = $_POST['category'];
    $room_number = $_POST['room_number'];
    $quantity = intval($_POST['quantity']);

    // Insert the specified quantity of items
    for ($i = 0; $i < $quantity; $i++) {
        $sql_insert = "INSERT INTO equipment (Equipment_name, Category, room_number) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sss", $equipment_name, $category, $room_number);
        $stmt->execute();
    }

    header("Location: inventory.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }
        form {
            display: inline-block;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
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
    </style>
    <script>
        function goBackToHome() {
            <?php if (isset($_SESSION['admin_id'])): ?>
                window.location.href = 'admin_home.php';
            <?php elseif (isset($_SESSION['staff_id'])): ?>
                window.location.href = 'staff_home.php';
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <h1>Add Inventory</h1>
    <form method="POST" action="addinventory.php">
        <label for="equipment_name">Equipment Name:</label>
        <input type="text" id="equipment_name" name="equipment_name" required>
        
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>
        
        <label for="room_number">Room Number:</label>
        <input type="text" id="room_number" name="room_number" required>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required>
        
        <button type="submit">Add to Inventory</button>
    </form>
    <br>
    <button onclick="goBackToHome()">Back to Home</button>
</body>
</html>