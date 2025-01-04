<?php
session_start();
include("database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

// Finding user-specific requests with equipment names
$sql_requests = "
    SELECT r.Request_ID, r.Room_no, r.Status, r.Request_date, r.Equipment_name, r.Quantity
    FROM request r
    WHERE r.stud_fac_ID = ?
    ORDER BY r.Request_date DESC
";
$stmt = $conn->prepare($sql_requests);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$request_result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
        .content {
            margin-top: 20px;
            animation: fadeIn 2s ease;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        table {
            width: 80%;
            margin: 0 auto;
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
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
        .inventory-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .inventory-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
    <a href="inventory.php" class="inventory-button">View Inventory</a>
    <p>Role: <?php echo ucfirst($user_role); ?></p>

    <h3>Your Requests</h3>
    <table border="1">
        <tr>
            <th>Request ID</th>
            <th>Room Number</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Equipment Name</th>
            <th>Quantity</th>
        </tr>
        <?php
        if ($request_result->num_rows > 0) {
            while ($row = $request_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Request_ID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Room_no']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Request_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Equipment_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No requests found</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="make_request.php">Make a Request</a> 
    <?php if ($user_role !== 'admin' && $user_role !== 'staff') { ?>
        <br>
        <a href="feedback.php">Give Feedback</a> 
        <br>
        <a href="user_view_feedback.php">View Response</a> 
    <?php } ?>
    <br>
    <a href="logout.php">Logout</a>

</body>
</html>