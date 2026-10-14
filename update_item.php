<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "Unauthorized.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['itemName'];
    $price = $_POST['price'];
    $condition = $_POST['condition'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE items SET itemName=?, price=?, condition=?, description=? WHERE item_id=? AND user_Id=?");
    $stmt->bind_param("ssssss", $name, $price, $condition, $description, $id, $_SESSION['email']);

    if ($stmt->execute()) {
        echo "Item updated successfully!";
    } else {
        echo "Error updating item.";
    }
}
?>
