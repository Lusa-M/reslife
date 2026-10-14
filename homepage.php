<?php
// Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include("connect.php");

$category = $_GET['category'] ?? '';
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Count items in cart
$cart_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_count += $item['quantity'];
}

// Fetch items from database
$itemsQuery = $conn->prepare("SELECT item_id, itemName, price, image, `condition` FROM items");
$itemsQuery->execute();
$itemsQuery->store_result();
$items = [];
$itemsQuery->bind_result($item_id, $itemName, $price, $image, $condition);
while ($itemsQuery->fetch()) {
    $items[] = [
        'item_id' => $item_id,
        'itemName' => $itemName,
        'price' => $price,
        'image' => $image,
        'condition' => $condition
    ];
}
$itemsQuery->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  
    <style>
/* Reset & Global Fixes */
html, body {
  margin: 0;
  padding: 0;
  max-width: 100vw;
  overflow-x: hidden;
  font-family: 'Segoe UI', sans-serif;
  scroll-behavior: smooth;
  background: #fefefe;
}

/* Navbar Styles */
.navbar-vertical {
  background: #222;
  padding: 15px 20px;
  color: white;
  position: sticky;
  top: 0;
  z-index: 999;
  width: 100%;
}

.container-vertical {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.logo-vertical {
  height: 60px;
}

.navbar-nav-vertical {
  display: flex;
  flex-direction: row;
  list-style: none;
  gap: 30px;
  align-items: center;
  padding: 0;
  margin: 0;
}

.navbar-nav-vertical .nav-link-vertical {
  color: #fff;
  text-decoration: none;
  font-size: 17px;
  transition: color 0.2s ease;
  padding: 10px 0;
}

.navbar-nav-vertical .nav-link-vertical:hover,
.navbar-nav-vertical .nav-link-vertical.active {
  color: #ffd700;
}

#lg-bag-vertical {
  position: relative;
}

#lg-bag-vertical span {
  position: absolute;
  top: -8px;
  right: -12px;
  background: red;
  color: white;
  font-size: 12px;
  padding: 2px 6px;
  border-radius: 50%;
}

/* Responsive Navbar */
@media (max-width: 768px) {
  .navbar-nav-vertical {
    flex-wrap: wrap;
    justify-content: center;
    gap: 18px;
  }
  .container-vertical {
    flex-direction: row;
    align-items: center;
    padding: 0 10px;
  }
  .logo-vertical {
    height: 40px;
  }
}

/* Hero Section */
#hero {
  background: url('img/student.jpeg') center center/cover no-repeat;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #fff;
  padding-left: 8vw;
  padding-top: 140px;
  background-position: 70% center;
}

#hero h4 {
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0;
  letter-spacing: 0.5px;
  line-height: 1.2;
}

#hero h2 {
  font-size: 3rem;
  font-weight: 800;
  margin: 0.2em 0 0.1em;
  letter-spacing: -0.5px;
  line-height: 1.1;
}

#hero h1 {
  font-size: 3.6rem;
  font-weight: 900;
  margin: 0 0 0.4em;
  line-height: 1;
}

#hero p {
  font-size: 1.3rem;
  font-weight: 500;
  max-width: 600px;
  line-height: 1.4;
  margin-bottom: 1.5em;
}

#hero a {
  background: orange;
  color: #fff;
  padding: 1em 2.5em;
  font-size: 1.1rem;
  border-radius: 30px;
  font-weight: bold;
  text-decoration: none;
  transition: background 0.2s, transform 0.2s;
}

/* Hero Mobile */
@media (max-width: 768px) {
  #hero {
    padding: 80px 20px 0 20px;
    background-position: 65% center;
    text-align: top;
    align-items: top;
    align-items: flex-start;
    justify-content: flex-start;
    padding-top: 60px;
    padding-left: 16px;
  }
   
  #hero h4 { font-size: 1.2rem; }
  #hero h2 { font-size: 2rem; }
  #hero h1 { font-size: 2.6rem; }
  #hero p  { font-size: 1rem; }
  #hero a {
    font-size: 1rem;
    padding: 0.5em 0.5em;
  }
}

/* Feature Boxes */
#feature.section-p1 {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 1em;
  padding: 2em 0;
  background: #f8f8f8;
  width: 100%;
}

.fe-box {
  background: #fff;
  border: 2px solid #ffd700;
  border-radius: 18px;
  padding: 1em 0.7em;
  width: 120px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  transition: box-shadow 0.2s;
}

.fe-box img {
  width: 40px;
  height: 40px;
  object-fit: contain;
  margin-bottom: 0.7em;
}

.fe-box h6 {
  background: #fffbe6;
  color: #222;
  padding: 0.4em 0.7em;
  border-radius: 10px;
  font-size: 0.95rem;
  font-weight: 600;
  border: 1.5px solid #ffd700;
  text-align: center;
}

/* Product Section */
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
  max-width: 1200px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .products-container {
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
}

/* Product Cards */
.product-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 18px 16px 20px 16px;
  transition: box-shadow 0.2s, transform 0.2s;
  text-align: center;
  width: 100%;
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
</style>

</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let lastScroll = 0;
    const navbar = document.querySelector('.navbar-vertical');

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll <= 20) {
            navbar.style.top = "0"; // Show if at top
        } else if (currentScroll > lastScroll) {
            navbar.style.top = "-100px"; // Hide on scroll down
        }

        lastScroll = currentScroll;
    });
});
</script>
    <!-- Navbar -->
    <nav id="header" class="navbar-vertical">
        <div class="container-vertical">
            <a href="#" class="navbar-brand-vertical">
                <img src="img/logo.png" class="logo-vertical" alt="Logo">
            </a>
            <ul class="navbar-nav-vertical">
                <li class="nav-item-vertical"><a class="nav-link-vertical active" href="homepage.php">Home</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="shop.php">Shop</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="sell.php">Sell</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item-vertical" id="lg-bag-vertical"><a class="nav-link-vertical" href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero">
        <h4>Trade-in-offer</h4>
        <h2>Super value deals</h2>
        <h1>On all products</h1>
        <p>Save more with coupons & up to 70% off! </p>
        <a href="shop.php">Shop Now</a>
    </section>

    
<section id="products" class="products-section">
    <div class="products-container">
        <?php if (count($items) > 0): ?>
            <?php foreach ($items as $item): ?>
                <div class="product-card">
                    <a href="item.php?id=<?php echo urlencode($item['item_id']); ?>" style="text-decoration: none; color: inherit;">
                        <div class="item-card">
                            <img class="product-img" src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>" />
                            <h3 class="product-title"><?php echo htmlspecialchars($item['itemName']); ?></h3>
                            <p class="product-price"><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                            <p class="product-desc"><?php echo htmlspecialchars($item['condition']); ?></p>
                        </div>
                    </a>
                    <div class="product-actions" style="justify-content: center;">
                        <form method="post" action="add_to_cart.php" style="display:inline;">
                            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>"> 
                            <button type="submit" style="padding: 6px 12px; font-size: 0.9rem; border-radius: 16px; background: #ffd700; color: #222; border: none; cursor: pointer;">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="font-size:1.2rem;color:#888;">No items found.</p>
        <?php endif; ?>
    </div>
</section>
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const navLinks = document.getElementById('nav-links');

  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('show');
  });
</script>

</body>
</html>