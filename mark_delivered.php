<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchase_id = $_POST['purchase_id'];

    $update = $conn->prepare("UPDATE purchases SET status = 'Delivered' WHERE purchase_id = ?");
    $update->bind_param("i", $purchase_id);
    $update->execute();
}

header("Location: admin_dashboard.php");
exit();
