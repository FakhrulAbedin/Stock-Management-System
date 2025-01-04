<?php
session_start();
include("database.php");


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'staff') {
    header("Location: home.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Finding user-specific feedback
$sql_feedback = "SELECT * FROM feedback WHERE user_id = ? ORDER BY time DESC";
$stmt = $conn->prepare($sql_feedback);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_feedback = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
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
        .back-button {
            display: inline-block;
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
    </style>
</head>
<body>
    <h1>View Your Feedback</h1>
    <table>
        <tr>
            <th>Feedback ID</th>
            <th>Description</th>
            <th>Time</th>
            <th>Response</th>
        </tr>
        <?php
        if ($result_feedback->num_rows > 0) {
            while ($row = $result_feedback->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['feedback_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                echo "<td>" . htmlspecialchars($row['response']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No feedback found</td></tr>";
        }
        ?>
    </table>
    <br><br>
    <a href="home.php" class="back-button">Back</a>
</body>
</html>