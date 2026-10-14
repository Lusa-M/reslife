<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "Unauthorized.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM items WHERE item_id=? AND user_Id=?");
    $stmt->bind_param("ss", $id, $_SESSION['email']);

    if ($stmt->execute()) {
        echo "Item deleted successfully!";
    } else {
        echo "Error deleting item.";
    }
}
?>
