<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add item to cart or increase quantity
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id]['quantity'] += 1;
    } else {
        // Fetch item from DB
        $stmt = $conn->prepare("SELECT item_id, itemName, price, image FROM items WHERE item_id = ?");
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $stmt->bind_result($db_item_id, $db_itemName, $db_price, $db_image);

        if ($stmt->fetch()) {
            $_SESSION['cart'][$item_id] = [
                'item_id' => $db_item_id,
                'itemName' => $db_itemName,
                'price' => $db_price,
                'image' => $db_image,
                'quantity' => 1
            ];
        }
    }

    // Redirect back
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
