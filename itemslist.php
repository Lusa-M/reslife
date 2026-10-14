<?php 
session_start();
include 'connect.php';

if (isset($_POST['listItem'])) {
    $category    = $_POST['category'] ?? '';
    $itemName    = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price       = $_POST['price'] ?? '';
    $condition   = $_POST['condition'] ?? '';
    $pickup_address = $_POST['pickup_address'] ?? '';
    $email       = $_SESSION['email'];
    $image       = $_FILES['image']['name'] ?? '';

    // Save user pickup address
    $check = $conn->query("SELECT * FROM user_info WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE user_info SET pickup_address='$pickup_address' WHERE email='$email'");
    } else {
        $conn->query("INSERT INTO user_info (email, pickup_address) VALUES ('$email', '$pickup_address')");
    }

    // Handle image folder
    $imagesDir = __DIR__ . "/images";
    if (!is_dir($imagesDir)) {
        mkdir($imagesDir, 0777, true);
    }
    $target = $imagesDir . "/" . basename($image);

    // Insert item into items table
    $stmt = $conn->prepare("INSERT INTO items (category, itemName, description, price, `condition`, user_Id, image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $category, $itemName, $description, $price, $condition, $email, $image);

    if ($stmt->execute()) {
        $item_id = $conn->insert_id; // Save correct item_id from items table

        // Move uploaded image
        if (!empty($image) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }

        // Optional additional details
        $category_path    = $_POST['category_path'] ?? '';
        $brand            = $_POST['brand'] ?? '';
        $power            = $_POST['power'] ?? '';
        $warranty         = $_POST['warranty'] ?? '';
        $non_stick        = $_POST['non_stick'] ?? '';
        $model            = $_POST['model'] ?? '';
        $whats_in_box     = $_POST['whats_in_box'] ?? '';
        $dishwasher_safe  = $_POST['dishwasher_safe'] ?? '';
        $appliance_type   = $_POST['appliance_type'] ?? '';
        $barcode          = $_POST['barcode'] ?? '';

        $insertDetails = $conn->prepare("INSERT INTO additional_details (
            item_id, category_path, brand, power, warranty, non_stick, model, whats_in_box, dishwasher_safe, appliance_type, barcode
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $insertDetails->bind_param(
            "issssssssss",
            $item_id,
            $category_path,
            $brand,
            $power,
            $warranty,
            $non_stick,
            $model,
            $whats_in_box,
            $dishwasher_safe,
            $appliance_type,
            $barcode
        );

        $insertDetails->execute();

        // Redirect to dashboard
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        echo "Failed to list item: " . $conn->error;
    }
}
?>

