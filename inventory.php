<?php
session_start();
include("database.php");


$search_category = isset($_GET['category']) ? $_GET['category'] : '';
$search_room = isset($_GET['room']) ? $_GET['room'] : '';
$search_name = isset($_GET['name']) ? $_GET['name'] : '';

// Finding distinct categories
$sql_categories = "SELECT DISTINCT Category FROM equipment";
$result_categories = $conn->query($sql_categories);

// Finding distinct rooms
$sql_rooms = "SELECT DISTINCT room_number FROM equipment";
$result_rooms = $conn->query($sql_rooms);


$sql = "SELECT Equipment_name, Category, room_number, COUNT(*) AS Quantity FROM equipment WHERE 1=1";

if ($search_category) {
    $sql .= " AND Category LIKE ?";
}
if ($search_room) {
    $sql .= " AND room_number LIKE ?";
}
if ($search_name) {
    $sql .= " AND Equipment_name LIKE ?";
}

$sql .= " GROUP BY Equipment_name, Category, room_number";

$stmt = $conn->prepare($sql);

$param_types = '';
$params = [];

if ($search_category) {
    $param_types .= 's';
    $params[] = '%' . $search_category . '%';
}
if ($search_room) {
    $param_types .= 's';
    $params[] = '%' . $search_room . '%';
}
if ($search_name) {
    $param_types .= 's';
    $params[] = '%' . $search_name . '%';
}

if ($params) {
    $stmt->bind_param($param_types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
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
        .search-form {
            margin-bottom: 20px;
        }
        .search-form select, .search-form input {
            padding: 10px;
            margin-right: 10px;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        .home-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function goBack() {
            window.location.href = document.referrer;
        }
    </script>
</head>
<body>
    <h1>Inventory</h1>
    <form class="search-form" method="GET" action="inventory.php">
        <select name="category">
            <option value="">Search by Category</option>
            <?php
            if ($result_categories->num_rows > 0) {
                while($row = $result_categories->fetch_assoc()) {
                    $selected = ($row['Category'] == $search_category) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row['Category']) . "' $selected>" . htmlspecialchars($row['Category']) . "</option>";
                }
            }
            ?>
        </select>
        <select name="room">
            <option value="">Search by Room</option>
            <?php
            if ($result_rooms->num_rows > 0) {
                while($row = $result_rooms->fetch_assoc()) {
                    $selected = ($row['room_number'] == $search_room) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row['room_number']) . "' $selected>" . htmlspecialchars($row['room_number']) . "</option>";
                }
            }
            ?>
        </select>
        <input type="text" name="name" placeholder="Search by Name" value="<?php echo htmlspecialchars($search_name); ?>">
        <button type="submit">Search</button>
    </form>
    <table>
        <tr>
            <th>Equipment Name</th>
            <th>Category</th>
            <th>Room Number</th>
            <th>Quantity</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["Equipment_name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Category"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["room_number"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No equipment found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <button onclick="goBack()" class="home-button">Back</button>
</body>
</html>