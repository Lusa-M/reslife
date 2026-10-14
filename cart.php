<?php
session_start();
include 'connect.php';

$cart = $_SESSION['cart'] ?? [];

// Fetch user info
$userEmail = $_SESSION['email'] ?? '';
$userInfo = $conn->query("SELECT * FROM user_info WHERE email = '$userEmail' LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f9f9f9;
        }

        .navbar-vertical {
            width: 100%;
            background: #222;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .block-vertical {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .navbar-brand-vertical {
            margin: 20px 0 10px 0;
        }
        .logo-vertical {
            height: 80px;
        }
        .navbar-nav-vertical {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            border-top: 1px solid #333;
        }
        .nav-item-vertical {
            margin: 0 20px;
        }
        .nav-link-vertical {
            color: #fff;
            text-decoration: none;
            padding: 18px 0;
            font-size: 18px;
        }
        .nav-link-vertical.active,
        .nav-link-vertical:hover {
            color: #ffd700;
        }
        #lg-bag-vertical .fa-shopping-bag {
            font-size: 20px;
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

        /* Cart layout */
        .cart-container {
            display: flex;
            max-width: 1200px;
            margin: 50px auto;
            gap: 40px;
            padding: 20px;
        }
        .checkout-form {
            flex: 1;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .checkout-form h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .checkout-form input, .checkout-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .checkout-form button {
            background: #ffd700;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #222;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .checkout-form button:hover {
            background: #ff9800;
            color: #fff;
        }

        .cart-summary-section {
            flex: 2;
        }

        .cart-summary-section h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .cart-item {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .cart-item img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .cart-item h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .cart-item p {
            margin: 0;
            font-size: 14px;
        }

        .remove-btn {
            background: none;
            border: none;
            color: red;
            margin-left: 10px;
            cursor: pointer;
        }

        .cart-summary {
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
            text-align: right;
        }

        @media (max-width: 768px) {
            .cart-container {
                flex-direction: column;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav id="header" class="navbar-vertical">
    <div class="block-vertical">
        <a href="#" class="navbar-brand-vertical">
            <img src="img/logo.png" class="logo-vertical" alt="Logo">
        </a>
        <ul class="navbar-nav-vertical">
            <li class="nav-item-vertical"><a class="nav-link-vertical" href="homepage.php">Home</a></li>
            <li class="nav-item-vertical"><a class="nav-link-vertical" href="shop.php">Shop</a></li>
            <li class="nav-item-vertical"><a class="nav-link-vertical" href="sell.php">Sell</a></li>
            <li class="nav-item-vertical"><a class="nav-link-vertical" href="dashboard.php">Dashboard</a></li>
            <li class="cart-count active" style="color:white;">
                <a href="cart.php" style="color:white; text-decoration:none;">
                    🛒 <i class="fas fa-shopping-cart"></i>
                    <span><?php echo isset($cartCount) ? $cartCount : count($cart); ?></span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- CART SECTION -->
<div class="cart-container">
    
    <!-- LEFT: Checkout form -->
    <?php if (!empty($cart)): ?>
    <div class="checkout-form">
        <h2>Checkout Information</h2>
        <form method="POST" action="process_checkout.php">
            <label>Student Number:</label>
            <input type="text" name="student_number" required value="<?php echo $userInfo['student_number'] ?? ''; ?>">

            <label>University:</label>
            <input type="text" name="university" required value="<?php echo $userInfo['university'] ?? ''; ?>">

            <label>Delivery Address:</label>
            <textarea name="delivery_address" required rows="3"><?php echo $userInfo['delivery_address'] ?? ''; ?></textarea>

            <button type="submit">Proceed to Pay</button>
        </form>
    </div>
    <?php endif; ?>

    <!-- RIGHT: Cart Summary -->
    <div class="cart-summary-section">
        <h1>Your Cart</h1>

        <?php if (empty($cart)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php 
                $total = 0; 
                foreach ($cart as $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <div class="cart-item">
                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="">
                <div>
                    <h3><?php echo htmlspecialchars($item['itemName']); ?></h3>
                    <p>Price: R<?php echo $item['price']; ?> | Qty: <?php echo $item['quantity']; ?> | Subtotal: R<?php echo $subtotal; ?></p>
                    <form method="post" action="remove_from_cart.php" style="display:inline;">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button class="remove-btn" type="submit">Remove</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                Total: R<?php echo number_format($total, 2); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
