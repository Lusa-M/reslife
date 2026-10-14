<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 60px;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        a {
            display: inline-block;
            margin-top: 30px;
            background: #ffd700;
            padding: 10px 20px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            border-radius: 30px;
        }
    </style>
</head>
<body>
    <h1>✅ Order placed successfully!</h1>
    <p>Thank you for your purchase. You will be notified when your order is delivered.</p>
    <a href="dashboard.php">Go to Dashboard</a>
</body>
</html>
