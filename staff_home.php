<?php
session_start(); 


if (!isset($_SESSION['staff_id'])) {
    header('Location: staff_login.php');
    exit;
}

include("database.php");


$staff_id = $_SESSION['staff_id'];
$sql_name = "SELECT Name FROM user WHERE ID = ?";
$stmt_name = $conn->prepare($sql_name);
if ($stmt_name === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt_name->bind_param("i", $staff_id);
$stmt_name->execute();
$result_name = $stmt_name->get_result();
$row_name = $result_name->fetch_assoc();
$user_name = $row_name['Name'];
$_SESSION['user_name'] = $user_name;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    // Updating task status to 'Completed'
    $update_task_sql = "UPDATE tasks SET Status = 'Completed', Completion_date = CURDATE() WHERE Assign_ID = ?";
    $stmt = $conn->prepare($update_task_sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();

    // Updating request status to 'Approved'
    $update_request_sql = "UPDATE request SET Status = 'Approved' WHERE Assigned_Staff_ID = ? AND Request_ID = (SELECT Request_ID FROM request_assing WHERE Assign_ID = ?)";
    $stmt = $conn->prepare($update_request_sql);
    $stmt->bind_param("ii", $_SESSION['staff_id'], $task_id);
    $stmt->execute();
}

// Finding staff and task data, excluding completed tasks, ordered by assignment date
$sql = "SELECT 
            t.Assign_ID AS task_id, 
            u.Name AS admin_name, 
            r.Room_no AS room_no,  
            r.Equipment_name AS equipment_name, 
            r.Quantity AS quantity, 
            a.Assign_date AS assign_date,
            a.Assign_time AS assign_time, 
            t.Task_description AS task_description 
        FROM tasks t
        JOIN assigns a ON t.Assign_ID = a.Assign_ID
        JOIN request_assing ra ON a.Assign_ID = ra.Assign_ID
        JOIN request r ON ra.Request_ID = r.Request_ID
        JOIN user u ON a.Admin_ID = u.ID
        WHERE a.Staff_ID = ? AND t.Status = 'Pending'
        ORDER BY a.Assign_date ASC";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $_SESSION['staff_id']);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Home Page</title>
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FF0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .logout-button:hover {
            background-color: #CC0000;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
    <h2>Your Tasks</h2>
    <table>
        <tr>
            <th>Task ID</th>
            <th>Admin Name</th>
            <th>Room No</th> 
            <th>Equipment Name</th>
            <th>Quantity</th>
            <th>Assigned Date</th>
            <th>Assigned Time</th> 
            <th>Task Description</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['task_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['admin_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['room_no']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['equipment_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                echo "<td>" . htmlspecialchars($row['assign_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['assign_time']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['task_description']) . "</td>"; 
                echo "<td>";
                echo "<form method='POST' action='staff_home.php' style='display:inline;'>";
                echo "<input type='hidden' name='task_id' value='" . htmlspecialchars($row['task_id']) . "'>";
                echo "<button type='submit' class='button'>Mark as Completed</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No tasks found</td></tr>"; 
        }
        ?>
    </table>
    <br>
    <a href="inventory.php" class="button">View Inventory</a>
    <a href="addinventory.php" class="button">Add Inventory</a>
    <br>
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>