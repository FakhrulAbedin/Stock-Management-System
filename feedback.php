<?php
session_start();
include("database.php");


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'staff') {
    header("Location: home.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST['feedback'];
    $feedback_id = uniqid();
    $sql_feedback = "INSERT INTO feedback (feedback_id, user_id, description, time) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql_feedback);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sis", $feedback_id, $user_id, $feedback);
    $stmt->execute();
    $message = "Feedback submitted successfully!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            color: #333;
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
        textarea {
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
        .message {
            color: green;
            margin-bottom: 20px;
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
    <h1>Give Feedback</h1>
    <?php if ($message) { ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>
    <form method="POST" action="feedback.php">
        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" rows="5" required></textarea>
        <button type="submit">Submit Feedback</button>
    </form>
    <br><br>
    <a href="home.php" class="back-button">Back</a>
</body>
</html>