<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include("connect.php");

$category = $_GET['category'] ?? '';
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$itemsResult = [];

try {
    if (!empty($category)) {
        $stmt = $conn->prepare("SELECT * FROM items WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();

        $meta = $stmt->result_metadata();
        if ($meta) {
            $fields = [];
            $row = [];
            while ($field = $meta->fetch_field()) {
                $fields[] = &$row[$field->name];
            }
            call_user_func_array([$stmt, 'bind_result'], $fields);
            while ($stmt->fetch()) {
                $item = [];
                foreach ($row as $key => $val) {
                    $item[$key] = $val;
                }
                $itemsResult[] = $item;
            }
        }
        $stmt->close();
    } else {
        $result = $conn->query("SELECT * FROM items");
        if ($result && $result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $itemsResult[] = $item;
            }
        }
    }

} catch (Exception $e) {
    die("Something went wrong while fetching products.");
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Shop by category</title>
</head>
   <style>
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
        display: block;
        color: #fff;
        text-decoration: none;
        padding: 18px 0;
        font-size: 18px;
        transition: color 0.2s;
    }
    .nav-link-vertical.active,
    .nav-link-vertical:hover {
        color: #ffd700;
    }
  .cart-count {
            position: relative;
            color:white;
            color:white; 
            text-decoration:none;"
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
    @media (max-width: 768px) {
.navbar-nav-vertical {
    flex-direction: row;
    gap: 18px;
}
.container-vertical {
    flex-direction: row;
    align-items: center;
    width: 100vw;
}
.logo-vertical {
    height: 40px;
}
    }

   body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 40px;
      background-color: #f5f5f5;
      text-align: center;
    }

    h1 {
      margin-bottom: 40px;
    }

    .category-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .category-block {
      width: 200px;
      height: 150px;
      background-size: cover;
      background-position: center;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: bold;
      color: white;
      text-decoration: none;
      transition: transform 0.2s ease;
    }

    .category-block:hover {
      transform: scale(1.05);
    }
    .electronics { background-image: url('img/categories/electronics.jpg'); }
    .books       { background-image: url('img/categories/books.jpg'); }
    .furniture   { background-image: url('img/categories/furniture.jpg'); }
    .thrift      { background-image: url('img/categories/thrift.jpg'); }
    .thrift      { background-image: url('img/categories/thrift.jpg'); }

      /* Product grid styles */
.products-section {
    background: #f5f6fa;
    padding: 40px 0 60px 0;
    width: 100%;
}

.products-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 32px;
  justify-content: center;
  padding: 0 16px;
}

@media (max-width: 768px) {
  .products-container {
    grid-template-columns: repeat(2, 1fr); /* 2 per row on small screens */
    gap: 16px;
  }
}


.product-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
    width: 240px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 18px 16px 20px 16px;
    transition: box-shadow 0.2s, transform 0.2s;
    position: relative;
    text-align: center;
}

.product-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.13);
    transform: translateY(-4px) scale(1.03);
}

.product-img {
    width: 160px;
    height: 160px;
    object-fit: contain;
    border-radius: 8px;
    margin-bottom: 14px;
    background: #f8f8f8;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #222;
    margin-bottom: 6px;
    min-height: 48px;
}

.product-price {
    font-size: 1.2rem;
    color: #ff9800;
    font-weight: bold;
    margin-bottom: 8px;
}

.product-desc {
    font-size: 0.97rem;
    color: #666;
    margin-bottom: 12px;
    min-height: 40px;
}

.product-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
}

.product-actions a,
.product-actions button {
    background: #ffd700;
    color: #222;
    border: none;
    border-radius: 20px;
    padding: 8px 18px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
}

.product-actions a:hover,
.product-actions button:hover {
    background: #ff9800;
    color: #fff;
}

/* Responsive adjustments */
@media (max-width: 1100px) {
    .products-container {
        gap: 24px;
    }
    .product-card {
        width: 200px;
    }
}

@media (max-width: 768px) {
    .products-container {
        flex-direction: column;
        align-items: center;
    }
    .product-card {
        width: 90vw;
    }
}
     
    }

    
</style>


      <nav id="header" class="navbar-vertical">
        <div class="block-vertical">
            <a href="#" class="navbar-brand-vertical">
                <img src="img/logo.png" class="logo-vertical" alt="Logo">
            </a>
            <ul class="navbar-nav-vertical">
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="homepage.php">Home</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical active" href="shop.php">Shop</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical " href="sell.php">Sell</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="dashboard.php">Dashboard</a></li>
<li class="cart-count" >
    <a href="cart.php" >
        🛒 <i class="fas fa-shopping-cart"></i>
        <span><?php echo isset($cartCount) ? $cartCount : 0; ?></span>
    </a>
</li>
</ul>
        </div>
    </nav>
 
<body>

  <h1>Shop by Category</h1>

  <div class="category-container">
    <a href="shop.php?category=Electronics" class="category-block electronics">Electronics</a>
    <a href="shop.php?category=Books/Stationery" class="category-block books">Books</a>
    <a href="shop.php?category=Furniture" class="category-block furniture">Furniture</a>
    <a href="shop.php?category=Thrift" class="category-block thrift">Thrift</a>
  </div>
  <h2 style="text-align:center; margin-top:20px;">
    <h2 style="text-align:center; margin-top:20px;">
<?php
if ($category == 'Electronics') {
    echo "🖥️ Shop Electronics";

        ?>
         <!-- Products Section -->
        <section id="products" class="products-section">
    <div class="products-container">
        <?php if (!empty($itemsResult)): ?>
            <?php foreach ($itemsResult as $item): ?>
                <div class="product-card">
                    <img class="product-img" src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>" />
                    <h3 class="product-title"><?php echo htmlspecialchars($item['itemName']); ?></h3>
                    <p class="product-price"><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                    <p class="product-desc"><?php echo htmlspecialchars($item['condition']); ?></p>
                    <div class="product-actions">
                        <a href="item.php?id=<?php echo urlencode($item['item_id']); ?>">View</a>
                        <form method="post" action="add_to_cart.php" style="display:inline;">
                            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>"> 
                            <button type="submit"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="font-size:1.2rem;color:#888;">No items found in this category.</p>
        <?php endif; ?>
    </div>
</section>
        <?php
    } elseif ($category == 'Books/Stationery') {
        echo "📚 Shop Books & Stationery";
        ?>
        <!-- Products Section -->
        <section id="products" class="products-section">
            <div class="products-container">
                <?php if (!empty($itemsResult)): ?>
                    <?php foreach ($itemsResult as $item): ?>
                        <div class="product-card">
                            <div class="item-card" onclick='openModal(<?php echo json_encode($item); ?>)'>
                                <img class="product-img" src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>" />
                                <h3 class="product-title"><?php echo htmlspecialchars($item['itemName']); ?></h3>
                                <p class="product-price"><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                                <p class="product-desc"><?php echo htmlspecialchars($item['condition']); ?></p>
                                <div class="product-actions">
                                    <a href="item.php?id=<?php echo urlencode($item['item_id']); ?>">View</a>
                                    <form method="post" action="add_to_cart.php" style="display:inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>"> 
                                        <button type="submit"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="font-size:1.2rem;color:#888;">No items found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    } elseif ($category == 'Furniture') {
        echo "🛋️ Shop Furniture";
        ?>
        <!-- Products Section -->
        <section id="products" class="products-section">
            <div class="products-container">
                <?php if (!empty($itemsResult)): ?>
                    <?php foreach ($itemsResult as $item): ?>
                        <div class="product-card">
                            <div class="item-card" onclick='openModal(<?php echo json_encode($item); ?>)'>
                                <img class="product-img" src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>" />
                                <h3 class="product-title"><?php echo htmlspecialchars($item['itemName']); ?></h3>
                                <p class="product-price"><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                                <p class="product-desc"><?php echo htmlspecialchars($item['condition']); ?></p>
                                <div class="product-actions">
                                    <a href="item.php?id=<?php echo urlencode($item['item_id']); ?>">View</a>
                                    <form method="post" action="add_to_cart.php" style="display:inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>"> 
                                        <button type="submit"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="font-size:1.2rem;color:#888;">No items found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    } elseif ($category == 'Thrift') {
        echo "👗 Shop Thrift Items";
        ?>
        <!-- Products Section -->
        <section id="products" class="products-section">
            <div class="products-container">
                <?php if (!empty($itemsResult)): ?>
                    <?php foreach ($itemsResult as $item): ?>
                        <div class="product-card">
                            <div class="item-card" onclick='openModal(<?php echo json_encode($item); ?>)'>
                                <img class="product-img" src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>" />
                                <h3 class="product-title"><?php echo htmlspecialchars($item['itemName']); ?></h3>
                                <p class="product-price"><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                                <p class="product-desc"><?php echo htmlspecialchars($item['condition']); ?></p>
                                <div class="product-actions">
                                    <a href="item.php?id=<?php echo urlencode($item['item_id']); ?>">View</a>
                                    <form method="post" action="add_to_cart.php" style="display:inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>"> 
                                        <button type="submit"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="font-size:1.2rem;color:#888;">No items found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    } else {
        echo "🛒 All Available Items";
    }
    ?>
</h2>
