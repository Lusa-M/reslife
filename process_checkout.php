<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php';

$cart = $_SESSION['cart'] ?? [];
$buyer_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    $student_number = $_POST['student_number'];
    $university = $_POST['university'];
    $delivery_address = $_POST['delivery_address'];

    // Save/update user info
    $check = $conn->prepare("SELECT email FROM user_info WHERE email = ?");
    $check->bind_param("s", $buyer_email);
    $check->execute();
    $check->store_result();
    $exists = $check->num_rows;

    if ($exists > 0) {
        $update = $conn->prepare("UPDATE user_info SET student_number=?, university=?, delivery_address=? WHERE email=?");
        $update->bind_param("ssss", $student_number, $university, $delivery_address, $buyer_email);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO user_info (email, student_number, university, delivery_address) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $buyer_email, $student_number, $university, $delivery_address);
        $insert->execute();
    }

    // Save purchases
    foreach ($cart as $item) {
        $item_id = $item['item_id'];

        // Get seller
        $sellerResult = $conn->query("SELECT user_Id FROM items WHERE item_id = $item_id");
        $sellerRow = $sellerResult->fetch_assoc();
        $seller_email = $sellerRow['user_Id'];

        $purchase = $conn->prepare("INSERT INTO purchases (item_id, buyer_email, seller_email) VALUES (?, ?, ?)");
        $purchase->bind_param("iss", $item_id, $buyer_email, $seller_email);
        $purchase->execute();
    }

    unset($_SESSION['cart']); // Clear cart
    header("Location: success.php");
    exit();
}
?>
