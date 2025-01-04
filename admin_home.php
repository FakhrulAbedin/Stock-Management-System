<?php
session_start();
include("database.php");

// Checking that admin is logging in or not
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

// Handling reject option
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reject_request_id'])) {
    $reject_request_id = $_POST['reject_request_id'];
    $sql_reject = "UPDATE request SET Status = 'Rejected' WHERE Request_ID = ?";
    $stmt_reject = $conn->prepare($sql_reject);
    $stmt_reject->bind_param("s", $reject_request_id);
    $stmt_reject->execute();
}

//Finding all the pending requests
$sql_requests = "SELECT * FROM request WHERE Status = 'Pending' ORDER BY Request_date DESC";
$result_requests = $conn->query($sql_requests);

// Finding all in-progress tasks
$sql_tasks = "SELECT * FROM request WHERE Status = 'In Progress' ORDER BY Request_date DESC";
$result_tasks = $conn->query($sql_tasks);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
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
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            animation: fadeInTable 2s ease;
        }
        @keyframes fadeInTable {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
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
            position: relative;
            overflow: hidden;
            height: 3rem;
            padding: 0 2rem;
            border-radius: 1.5rem;
            background: #3d3a4e;
            background-size: 400%;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .button:hover::before {
            transform: scaleX(1);
        }
        .button-content {
            position: relative;
            z-index: 1;
        }
        .button::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            transform: scaleX(0);
            transform-origin: 0 50%;
            width: 100%;
            height: inherit;
            border-radius: inherit;
            background: linear-gradient(
                82.3deg,
                rgba(150, 93, 233, 1) 10.8%,
                rgba(99, 88, 238, 1) 94.3%
            );
            transition: all 0.475s;
        }
        .reject-button {
            background-color: #FF0000;
        }
        .reject-button:hover {
            background-color: #CC0000;
        }
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
        }
        .tab.active {
            background-color: #0056b3;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
    <script>
        function showTab(tabIndex) {
            var tabs = document.getElementsByClassName('tab');
            var contents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
                contents[i].classList.remove('active');
            }
            tabs[tabIndex].classList.add('active');
            contents[tabIndex].classList.add('active');
        }
    </script>
</head>
<body onload="showTab(0)">
    <header>Welcome, <?php echo htmlspecialchars($admin_name); ?></header>
    <h1>Admin Home Page</h1>
    <div class="tabs">
        <button class="tab" onclick="showTab(0)">Pending Requests</button>
        <button class="tab" onclick="showTab(1)">In Progress Tasks</button>
    </div>
    <div class="tab-content" id="pending-requests">
        <h2>Pending Requests</h2>
        <table>
            <tr>
                <th>Request ID</th>
                <th>User ID</th>
                <th>Room No</th>
                <th>Equipment Name</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result_requests->num_rows > 0) {
                while ($row = $result_requests->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Request_ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['stud_fac_ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Room_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Equipment_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Request_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                    echo "<td>";
                    echo "<a href='assign.php?request_id=" . htmlspecialchars($row['Request_ID']) . "' class='button'>Assign</a>";
                    echo "<form method='POST' action='admin_home.php' style='display:inline;'>";
                    echo "<input type='hidden' name='reject_request_id' value='" . htmlspecialchars($row['Request_ID']) . "'>";
                    echo "<button type='submit' class='button reject-button'>Reject</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No pending requests available.</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="tab-content" id="in-progress-tasks">
        <h2>In Progress Tasks</h2>
        <table>
            <tr>
                <th>Request ID</th>
                <th>User ID</th>
                <th>Room No</th>
                <th>Equipment Name</th> 
                <th>Status</th>
                <th>Request Date</th>
                <th>Quantity</th>
            </tr>
            <?php
            if ($result_tasks->num_rows > 0) {
                while ($row = $result_tasks->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Request_ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['stud_fac_ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Room_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Equipment_name']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Request_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No in-progress tasks available.</td></tr>"; 
            }
            ?>
        </table>
    </div>
    <br>
    <a href="inventory.php" class="button"><span class="button-content">View Inventory</span></a>
    <br><br>
    <a href="addinventory.php" class="button"><span class="button-content">Add Inventory</span></a>
    <br><br>
    <a href="view_feedback.php" class="button"><span class="button-content">View Feedback</span></a> 
    <br><br>
    <a href="logout.php" class="button"><span class="button-content">Logout</span></a>
</body>
</html>