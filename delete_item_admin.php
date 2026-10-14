<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

    $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
    $stmt->bind_param("s", $itemId);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
