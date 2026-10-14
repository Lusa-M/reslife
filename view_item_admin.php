<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Item ID is missing.";
    exit();
}

$itemId = $_GET['id'];

// Get item + user info
$stmt = $conn->prepare("SELECT i.*, u.firstName, u.lastName, u.email 
                        FROM items i 
                        JOIN users u ON i.user_Id = u.email 
                        WHERE i.item_id = ?");
$stmt->bind_param("s", $itemId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Item not found.";
    exit();
}

$item = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Item Details (Admin)</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
            background: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            font-size: 1.1rem;
            margin: 10px 0;
        }
        .back {
            margin-top: 20px;
        }
        .back a {
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($item['itemName']); ?></h2>
        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="">
        <div class="info">
            <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
            <p><strong>Condition:</strong> <?php echo htmlspecialchars($item['condition']); ?></p>
            <p><strong>Price:</strong> R<?php echo htmlspecialchars($item['price']); ?></p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
            <hr>
            <h3>Seller Information</h3>
            <p><strong>Name:</strong> <?php echo $item['firstName'] . " " . $item['lastName']; ?></p>
            <p><strong>Email:</strong> <?php echo $item['email']; ?></p>
        </div>
        <div class="back">
            <a href="admin_dashboard.php">&larr; Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
