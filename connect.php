<?php
$servername = "localhost";
$username = "mmconsul_reslife_user";
$password = "hfTxA5qLtnhZWmuZWWay";
$database = "mmconsul_reslife_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
