<?php
session_start();
include("database.php");


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handling response submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback_id']) && isset($_POST['response'])) {
    $feedback_id = $_POST['feedback_id'];
    $response = $_POST['response'];
    $sql_response = "UPDATE feedback SET response = ? WHERE feedback_id = ?";
    $stmt = $conn->prepare($sql_response);
    $stmt->bind_param("ss", $response, $feedback_id);
    $stmt->execute();
}

// Collecting all feedback
$sql_feedback = "SELECT * FROM feedback ORDER BY time DESC";
$result_feedback = $conn->query($sql_feedback);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
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
        .response-form {
            display: inline-block;
            margin-top: 10px;
        }
        .response-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .response-form button {
            background: #007BFF;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .response-form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h1>View Feedback</h1>
    <table>
        <tr>
            <th>Feedback ID</th>
    
            <th>Description</th>
            <th>Time</th>
            <th>Response</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result_feedback->num_rows > 0) {
            while ($row = $result_feedback->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['feedback_id']) . "</td>";
            
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                echo "<td>" . htmlspecialchars($row['response']) . "</td>";
                echo "<td>";
                echo "<form method='POST' action='view_feedback.php' class='response-form'>";
                echo "<input type='hidden' name='feedback_id' value='" . htmlspecialchars($row['feedback_id']) . "'>";
                echo "<textarea name='response' rows='2' placeholder='Enter your response'>" . htmlspecialchars($row['response']) . "</textarea>";
                echo "<button type='submit'>Submit Response</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No feedback found</td></tr>";
        }
        ?>
    </table>
    <br><br>
    <a href="admin_home.php" class="back-button">Back</a>
</body>
</html>