<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

// Get user info
$userQuery = $conn->prepare("SELECT id, firstName, lastName, email, password FROM users WHERE email = ?");
$userQuery->bind_param("s", $userEmail);
$userQuery->execute();
$userQuery->store_result();
$userQuery->bind_result($id, $firstName, $lastName, $email, $password);
$user = null;
if ($userQuery->fetch()) {
    $user = [
        'user_id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => $password
    ];
}
$userQuery->close();

// Get user's items
$itemsQuery = $conn->prepare("SELECT item_id, itemName, price, image, `condition`, description FROM items WHERE user_Id = ?");
$itemsQuery->bind_param("s", $userEmail);
$itemsQuery->execute();
$itemsQuery->bind_result($item_id, $itemName, $price, $image, $condition, $description);
$itemsResult = [];
while ($itemsQuery->fetch()) {
    $itemsResult[] = [
        'item_id' => $item_id,
        'itemName' => $itemName,
        'price' => $price,
        'image' => $image,
        'condition' => $condition,
        'description' => $description
    ];
}
$itemsQuery->close();

// Get sold items
$soldQuery = $conn->prepare("SELECT items.image, items.itemName, items.price, purchases.status FROM purchases JOIN items ON purchases.item_id = items.item_id WHERE seller_email = ?");
$soldQuery->bind_param("s", $userEmail);
$soldQuery->execute();
$soldQuery->bind_result($image, $itemName, $price, $purchase_status);
$soldItems = [];
while ($soldQuery->fetch()) {
    $soldItems[] = [
        'image' => $image,
        'itemName' => $itemName,
        'price' => $price,
        'status' => $purchase_status
    ];
}
$soldQuery->close();

// Get purchased items
$purchaseQuery = $conn->prepare("SELECT items.image, items.itemName, items.price, items.condition, purchases.status FROM purchases JOIN items ON purchases.item_id = items.item_id WHERE buyer_email = ?");
$purchaseQuery->bind_param("s", $userEmail);
$purchaseQuery->execute();
$purchaseQuery->bind_result($image, $itemName, $price, $condition, $purchase_status);
$purchasedItems = [];
while ($purchaseQuery->fetch()) {
    $purchasedItems[] = [
        'image' => $image,
        'itemName' => $itemName,
        'price' => $price,
        'condition' => $condition,
        'status' => $purchase_status
    ];
}
$purchaseQuery->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f4f4f4;
        }

        .nav {
            background: #222;
            padding: 15px;
            text-align: center;
        }

        .nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
        }

        .container {
            padding: 30px;
        }

       .item-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}

.item-card {
    background: white;
    border-radius: 10px;
    width: 240px;
    padding: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
}
        .item-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
        }

        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 400px;
            position: relative;
        }

        .modal-content img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .modal-content input, .modal-content textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }

        .modal-content button {
            padding: 8px 12px;
            margin-right: 10px;
        }

        .close {
            position: absolute;
            top: 8px;
            right: 12px;
            font-size: 18px;
            cursor: pointer;
            color: red;
        }

        @media(max-width: 768px) {
    .item-grid {
        flex-direction: column;
        align-items: center;
    }

    .item-card {
        width: 90vw;
    }
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

        .dashboard-wrapper {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 220px;
    background-color: #333;
    color: white;
    padding: 30px 10px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar h3 {
    margin-bottom: 20px;
    text-align: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 20px 0;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    display: block;
}

.sidebar ul li a:hover {
    color: #ffd700;
}

.dashboard-content {
    flex: 1;
    padding: 30px;
}

.faq {
    margin-bottom: 10px;
    cursor: pointer;
    background: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    font-weight: bold;
}

.faq-answer {
    display: none;
    margin-top: 5px;
    padding: 10px;
}
    </style>
</head>

<body>

<div class="nav">
    <a href="homepage.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="sell.php">Sell</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>

<div class="dashboard-wrapper">

<div class="sidebar">
    <h3>Dashboard</h3>
    <ul>
    <li><a href="#" onclick="showTab('listed')">📦 Listed Items</a></li>
    <li><a href="#" onclick="showTab('sold')">✅ Sold Items</a></li>
    <li><a href="#" onclick="showTab('bought')">🛒 My Purchases</a></li>
    <li><a href="#" onclick="showTab('account')">👤 Account Information</a></li>
    <li><a href="#" onclick="showTab('faqs')">❓ FAQs</a></li>
</ul>

</div>


            

    <!-- Content -->
    <div class="dashboard-content">
        <div id="listed" class="tab-section">
            <h2>Welcome, <?php echo htmlspecialchars($user['firstName']); ?>! Here are your listings:</h2>
            <div class="item-grid">
                <?php foreach ($itemsResult as $item): ?>
                    <div class="item-card" onclick='openModal(<?php echo json_encode($item); ?>)'>
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" />
                        <h3><?php echo htmlspecialchars($item['itemName']); ?></h3>
                        <p><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                        <p><?php echo htmlspecialchars($item['condition']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="sold" class="tab-section" style="display:none;">
            <h2>Sold Items</h2>
            <?php if (count($soldItems) > 0): ?>
                <?php foreach ($soldItems as $sold): ?>
                    <div class="item-card">
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" />
                        <h3><?php echo htmlspecialchars($item['itemName']); ?></h3>
                        <p><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                        <p>Status: <strong style="color:<?php echo $sold['status'] === 'Delivered' ? 'green' : 'orange'; ?>">
                            <?php echo htmlspecialchars($sold['status']); ?>
                        </strong></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You haven’t sold anything yet.</p>
            <?php endif; ?>
        </div>
        <div id="bought" class="tab-section" style="display:none;">
            <h2>My Purchases</h2>
            <?php if (count($purchasedItems) > 0): ?>
                <?php foreach ($purchasedItems as $purchase): ?>
                    <div class="item-card">
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" />
                        <h3><?php echo htmlspecialchars($item['itemName']); ?></h3>
                        <p><strong>R<?php echo htmlspecialchars($item['price']); ?></strong></p>
                        <p>Status: <strong style="color:<?php echo $purchase['status'] === 'Delivered' ? 'green' : 'orange'; ?>">
                            <?php echo htmlspecialchars($purchase['status']); ?>
                        </strong></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You haven’t bought anything yet.</p>
            <?php endif; ?>
        </div>


        <!-- FAQs -->
        <div id="faqs" class="tab-section" style="display:none;">
            <h2>Frequently Asked Questions</h2>

            <div class="faq" onclick="toggleAnswer(this)">How do I list an item?</div>
            <div class="faq-answer">Click "Sell", fill in the item details, upload an image and submit.</div>

            <div class="faq" onclick="toggleAnswer(this)">How do I know if my item was sold?</div>
            <div class="faq-answer">You will receive a notification and see it listed under "Sold Items".</div>

            <div class="faq" onclick="toggleAnswer(this)">Can I delete my item?</div>
            <div class="faq-answer">Yes. Click on the item in your dashboard and press the "Delete" button.</div>
        </div>

    </div>
</div>

<script>
function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab-section');
    tabs.forEach(tab => tab.style.display = 'none');
    document.getElementById(tabId).style.display = 'block';
}

function toggleAnswer(faqElement) {
    const answer = faqElement.nextElementSibling;
    const visible = answer.style.display === 'block';
    answer.style.display = visible ? 'none' : 'block';
}

function openModal(item) {
    document.getElementById('itemModal').style.display = 'flex';
    document.getElementById('modalImage').src = 'images/' + item.image;
    document.getElementById('itemName').value = item.itemName;
    document.getElementById('price').value = item.price;
    document.getElementById('condition').value = item.condition;
    document.getElementById('description').value = item.description;
    document.getElementById('itemId').value = item.item_id;
}

function closeModal() {
    document.getElementById('itemModal').style.display = 'none';
}

function updateItem() {
    const id = document.getElementById('itemId').value;
    const itemName = document.getElementById('itemName').value;
    const price = document.getElementById('price').value;
    const condition = document.getElementById('condition').value;
    const description = document.getElementById('description').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_item.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        alert(this.responseText);
        location.reload();
    };
    xhr.send(
        "id=" + encodeURIComponent(id) +
        "&itemName=" + encodeURIComponent(itemName) +
        "&price=" + encodeURIComponent(price) +
        "&condition=" + encodeURIComponent(condition) +
        "&description=" + encodeURIComponent(description)
    );
}

function deleteItem() {
    const id = document.getElementById('itemId').value;
    if (!confirm("Are you sure you want to delete this item?")) return;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_item.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        alert(this.responseText);
        location.reload();
    };
    xhr.send(`id=${id}`);
}


</script>
<!-- Item Modal for Edit/Delete -->
<div class="modal" id="itemModal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="">
    <input type="text" id="itemName">
    <input type="text" id="price">
    <input type="text" id="condition">
    <textarea id="description"></textarea>
    <input type="hidden" id="itemId">
    <button onclick="updateItem()">Update</button>
    <button onclick="deleteItem()" style="background: red; color: white;">Delete</button>
  </div>
</div>

<script>
window.onload = function () {
    showTab('listed');
};
</script>

</body>
</html>
