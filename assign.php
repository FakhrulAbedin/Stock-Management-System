<?php
session_start();

// Checking admin logged in or not
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $task_description = $_POST['task_description'];
    $request_id = $_POST['request_id']; 

    // Checking the Request_ID exists in the request table
    $sql_check_request = "SELECT Request_ID FROM request WHERE Request_ID = ?";
    $stmt_check_request = $conn->prepare($sql_check_request);
    $stmt_check_request->bind_param("s", $request_id);
    $stmt_check_request->execute();
    $result_check_request = $stmt_check_request->get_result();

    if ($result_check_request->num_rows > 0) {
        // Updating the request with the assigned staff and setting the status to 'In Progress'
        $sql_assign = "UPDATE request SET Assigned_Staff_ID = ?, Status = 'In Progress' WHERE Request_ID = ?";
        $stmt = $conn->prepare($sql_assign);
        $stmt->bind_param("is", $staff_id, $request_id);
        $stmt->execute();


        $sql_assigns = "INSERT INTO assigns (Admin_ID, Staff_ID, Assign_date, Assign_time) VALUES (?, ?, CURDATE(), CURTIME())";
        $stmt_assigns = $conn->prepare($sql_assigns);
        $admin_id = $_SESSION['admin_id'];
        $stmt_assigns->bind_param("ii", $admin_id, $staff_id);
        $stmt_assigns->execute();
        $assign_id = $conn->insert_id;

    
        $sql_task = "INSERT INTO tasks (Assign_ID, Task_description, Status) VALUES (?, ?, 'Pending')";
        $stmt_task = $conn->prepare($sql_task);
        $stmt_task->bind_param("is", $assign_id, $task_description);
        $stmt_task->execute();

        // Inserting into request_assigning table
        $sql_request_assing = "INSERT INTO request_assing (Request_ID, Assign_ID) VALUES (?, ?)";
        $stmt_request_assing = $conn->prepare($sql_request_assing);
        $stmt_request_assing->bind_param("si", $request_id, $assign_id);
        $stmt_request_assing->execute();

        header("Location: admin_home.php");
        exit();
    } else {
        echo "Invalid Request ID.";
    }
}

// Finding staff list with task count
$sql_staff = "
    SELECT u.ID, u.Name, COUNT(t.Assign_ID) AS Task_Count
    FROM user u
    JOIN staff s ON u.ID = s.Staff_ID
    LEFT JOIN assigns a ON s.Staff_ID = a.Staff_ID
    LEFT JOIN tasks t ON a.Assign_ID = t.Assign_ID AND t.Status = 'Pending'
    GROUP BY u.ID, u.Name
";
$stmt_staff = $conn->prepare($sql_staff);
$stmt_staff->execute();
$result_staff = $stmt_staff->get_result();

$request_id = isset($_GET['request_id']) ? $_GET['request_id'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Task</title>
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
        input[type="text"], textarea, select {
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
</head>
<body>
    <h1>Assign Task</h1>
    <form method="POST" action="assign.php">
        <label for="request_id">Request ID:</label>
        <input type="text" id="request_id" name="request_id" value="<?php echo htmlspecialchars($request_id); ?>" readonly><br><br>
        <label for="staff_id">Staff:</label>
        <select id="staff_id" name="staff_id" required>
            <?php
            while ($row = $result_staff->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['ID']) . "'>" . htmlspecialchars($row['Name']) . " (Pending Tasks: " . htmlspecialchars($row['Task_Count']) . ")</option>";
            }
            ?>
        </select><br><br>
        <label for="task_description">Task Description:</label>
        <textarea id="task_description" name="task_description" required></textarea><br><br>
        <button type="submit">Assign Task</button>
    </form>
</body>
</html>