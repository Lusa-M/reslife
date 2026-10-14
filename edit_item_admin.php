<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $id = $_POST['item_id'];
    $stmt = $conn->prepare("SELECT item_id, itemName, price, description, `condition` FROM items WHERE item_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($item_id, $itemName, $price, $description, $condition);
    if ($stmt->fetch()) {
        $item = [
            'item_id' => $item_id,
            'itemName' => $itemName,
            'price' => $price,
            'description' => $description,
            'condition' => $condition
        ];
    } else {
        $item = null;
    }
    $stmt->close();
}
if (isset($_POST['update'])) {
    $id = $_POST['item_id'];
    $name = $_POST['itemName'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $condition = $_POST['condition'];

    $stmt = $conn->prepare("UPDATE items SET itemName=?, price=?, description=?, `condition`=? WHERE item_id=?");
    $stmt->bind_param("sssss", $name, $price, $desc, $condition, $id);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Item</title></head>
<body>
<h2>Edit Item</h2>
<form method="post">
    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
    <p>Name: <input type="text" name="itemName" value="<?php echo $item['itemName']; ?>"></p>
    <p>Price: <input type="text" name="price" value="<?php echo $item['price']; ?>"></p>
    <p>Condition: <input type="text" name="condition" value="<?php echo $item['condition']; ?>"></p>
    <p>Description:<br><textarea name="description"><?php echo $item['description']; ?></textarea></p>
    <button type="submit" name="update">Update</button>
</form>
<a href="admin_dashboard.php">Cancel</a>
</body>
</html>
