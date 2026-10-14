<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'connect.php';

// ✅ Get item_id early so it's available for all queries
$item_id = $_GET['id'] ?? null;
if (!$item_id) { echo "<p>Item not found.</p>"; exit(); }

// Fetch additional details FIRST now that $item_id is defined
$detailsStmt = $conn->prepare("SELECT * FROM additional_details WHERE item_id = ?");
$detailsStmt->bind_param("i", $item_id);
$detailsStmt->execute();
$meta = $detailsStmt->result_metadata();
$fields = [];
$extra = [];
if ($meta) {
    while ($field = $meta->fetch_field()) {
        $fields[] = &$extra[$field->name];
    }
    call_user_func_array([$detailsStmt, 'bind_result'], $fields);
    if ($detailsStmt->fetch()) {
        // $extra is populated
    } else {
        $extra = null;
    }
    $meta->free();
} else {
    $extra = null;
}
$detailsStmt->close();


// Explicitly select columns to match bind_result variables
$stmt = $conn->prepare("SELECT item_id, itemName, price, image, description, `condition`, category FROM items WHERE item_id = ?");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) { echo "<p>Item not found.</p>"; exit(); }

$stmt->bind_result($item_id_db, $itemName, $price, $image, $description, $condition, $category);
$stmt->fetch();
$item = [
    'item_id' => $item_id_db,
    'itemName' => $itemName,
    'price' => $price,
    'image' => $image,
    'description' => $description,
    'condition' => $condition,
    'category' => $category
];

$stmt->close();

// Also explicitly select columns for similar items
$similarStmt = $conn->prepare("SELECT item_id, itemName, price, image, description, `condition`, category FROM items WHERE category = ? AND item_id != ? LIMIT 4");
$similarStmt->bind_param("si", $category, $item_id);
$similarStmt->execute();
$similarStmt->store_result();
$similarStmt->bind_result($sim_item_id, $sim_itemName, $sim_price, $sim_image, $sim_description, $sim_condition, $sim_category);
$similarItems = [];
while ($similarStmt->fetch()) {
    $similarItems[] = [
        'item_id' => $sim_item_id,
        'itemName' => $sim_itemName,
        'price' => $sim_price,
        'image' => $sim_image,
        'description' => $sim_description,
        'condition' => $sim_condition,
        'category' => $sim_category
    ];
}
$similarStmt->close();

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($item['itemName']); ?> | ResLife</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
        }

        .navbar-vertical {
            width: 100%;
            background: #222;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .navbar-nav-vertical {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            border-top: 1px solid #333;
        }
        .nav-item-vertical {
            margin: 0 20px;
        }
        .nav-link-vertical {
            color: white;
            text-decoration: none;
            padding: 18px 0;
            display: block;
            font-size: 18px;
        }
        .nav-link-vertical.active,
        .nav-link-vertical:hover {
            color: #ffd700;
        }
        .cart-count {
            position: relative;
        }
        .cart-count span {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        .item-page {
            max-width: 1200px;
            display: flex;
            flex-wrap: wrap;
            margin: 40px auto;
            gap: 40px;
            padding: 0 20px;
        }
        .item-image {
            flex: 1;
            max-width: 450px;
        }
        .item-details {
            flex: 2;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .item-details h2 {
            margin-top: 0;
        }
        .item-details button {
            background: #ffd700;
            padding: 10px 24px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.2s;
        }
        .item-details button:hover {
            background: #ff9800;
            color: white;
        }

        .similar-items {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
        }
        .similar-items h3 {
            margin-bottom: 20px;
        }
        .similar-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .product-card {
            background: white;
            border-radius: 12px;
            width: 220px;
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.03);
        }
        .product-img {
    width: 100%;
    height: 240px;
    object-fit: contain;
    border-radius: 8px;
    background: #f8f8f8;
}

        .product-card h4 {
            margin: 10px 0 6px;
            font-size: 18px;
        }
        .product-card p {
            color: #ff9800;
            font-weight: bold;
        }

        @media(max-width: 768px) {
            .item-page {
                flex-direction: column;
            }
            .product-card {
                width: 100%;
            }
        }
    </style>
</head>
<!-- NAVBAR -->
<nav class="navbar-vertical">
    <ul class="navbar-nav-vertical">
        <li class="nav-item-vertical"><a class="nav-link-vertical" href="homepage.php">Home</a></li>
        <li class="nav-item-vertical"><a class="nav-link-vertical" href="shop.php">Shop</a></li>
        <li class="nav-item-vertical"><a class="nav-link-vertical" href="sell.php">Sell</a></li>
        <li class="nav-item-vertical"><a class="nav-link-vertical" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item-vertical cart-count">
            <a class="nav-link-vertical" href="cart.php">
                <i class="fas fa-shopping-cart"></i>
                <span><?php echo $cartCount; ?></span>
            </a>
        </li>
    </ul>
</nav>

<div class="item-page">
    <div class="item-image">
        <img class="product-img" src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>">
    </div>
    <div class="item-details">
        <h2><?php echo htmlspecialchars($item['itemName']); ?></h2>
        <p><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
        <p><strong>Condition:</strong> <?php echo htmlspecialchars($item['condition']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
        <form method="post" action="add_to_cart.php">
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
            <button type="submit"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </form>
    </div>
</div>

<!-- SIMILAR ITEMS -->
<div class="similar-items">
    <h3>Similar Items</h3>
    <div class="similar-grid">
        <?php foreach ($similarItems as $similar): ?>
            <div class="product-card">
                <a href="item.php?id=<?php echo $similar['item_id']; ?>" style="text-decoration: none; color: inherit;">
                    <img class="product-img" src="images/<?php echo htmlspecialchars($similar['image']); ?>" alt="<?php echo htmlspecialchars($similar['itemName']); ?>">
                    <h4><?php echo htmlspecialchars($similar['itemName']); ?></h4>
                    <p>R<?php echo htmlspecialchars($similar['price']); ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div> <!-- closing .similar-grid -->
</div> <!-- closing .similar-items -->
<?php if ($extra): ?>
<div class="additional-details" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    <h3>Additional Product Details</h3>
    <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden;">
        <tbody>
            <?php foreach ($extra as $key => $value): ?>
                <?php if ($key !== 'item_id' && !empty($value)): ?>
                    <tr>
                        <td style="padding: 12px; font-weight: bold;"><?php echo ucwords(str_replace('_', ' ', $key)); ?></td>
                        <td style="padding: 12px;"><?php echo nl2br(htmlspecialchars($value)); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>


    </div>
</div>

</body>
</html>
