<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include 'connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all listed items
$itemsResult = $conn->query("SELECT * FROM items ORDER BY item_id DESC");

// Example: Fetch total sales count
$totalSold = 0;
$totalSoldQuery = $conn->query("SELECT COUNT(*) as totalSold FROM purchases");
if ($totalSoldQuery && $row = $totalSoldQuery->fetch_assoc()) {
    $totalSold = $row['totalSold'];
}

// Example: Fetch total revenue
$revenueQuery = $conn->query("SELECT SUM(items.price) as totalRevenue FROM purchases JOIN items ON purchases.item_id = items.item_id");
if ($revenueQuery && $row = $revenueQuery->fetch_assoc()) {
    $totalRevenue = $row['totalRevenue'] ?? 0;
} else {
    $totalRevenue = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f8f8f8;
        }

        .nav {
            background: #000;
            padding: 15px;
            text-align: center;
        }

        .nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        .dashboard-container {
            padding: 30px;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .item-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .item-card {
            width: 250px;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
        }

        .item-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-card h4 {
            margin: 10px 0 5px;
        }

        .actions {
            margin-top: 10px;
        }

        .actions button {
            margin-right: 5px;
            padding: 6px 12px;
            font-size: 14px;
        }

        .delete {
            background: red;
            color: white;
        }

        .edit {
            background: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="nav">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_logout.php">Logout</a>
</div>

<div class="dashboard-container">
    <h1>Admin Panel</h1>

    <div class="stats">
        <div class="stat-card">
            <h2>Total Sales</h2>
            <p><?php echo $totalSold; ?></p>
        </div>
        <div class="stat-card">
            <h2>Total Revenue</h2>
            <p>R<?php echo number_format($totalRevenue, 2); ?></p>
        </div>
    </div>

    <h2>All Listed Items</h2>
    <div class="item-grid">
        <?php while($item = $itemsResult->fetch_assoc()): ?>
            <div class="item-card">
                <a href="view_item_admin.php?id=<?php echo urlencode($item['item_id']); ?>" style="text-decoration:none; color:inherit;">
    <img src="images/<?php echo htmlspecialchars($item['image']); ?>" />
    <h4><?php echo htmlspecialchars($item['itemName']); ?></h4>
    <p>R<?php echo htmlspecialchars($item['price']); ?></p>
    <p><em><?php echo htmlspecialchars($item['category']); ?></em></p>
</a>

                <div class="actions">
                    <form action="edit_item_admin.php" method="post" style="display:inline;">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button class="edit">Edit</button>
                    </form>
                    <form action="delete_item_admin.php" method="post" style="display:inline;" onsubmit="return confirm('Delete this item?');">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button class="delete">Delete</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <h2>Deliveries</h2>
<div class="item-grid">
    <?php
    $deliveryQuery = $conn->query("SELECT purchases.*, items.itemName, items.image, items.price, user_info.delivery_address FROM purchases 
    JOIN items ON purchases.item_id = items.item_id 
    LEFT JOIN user_info ON purchases.buyer_email = user_info.email 
    WHERE status != 'Delivered'");

    while($order = $deliveryQuery->fetch_assoc()): ?>
        <div class="item-card">
            <img src="images/<?php echo htmlspecialchars($order['image']); ?>" />
            <h3><?php echo htmlspecialchars($order['itemName']); ?></h3>
            <p>R<?php echo htmlspecialchars($order['price']); ?></p>
            <p><strong>Deliver to:</strong><br> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
            <form method="post" action="mark_delivered.php">
                <input type="hidden" name="purchase_id" value="<?php echo $order['purchase_id']; ?>">
                <button class="edit">Mark as Delivered</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

</div>
</body>
</html>
