<?php
session_start();
include 'connect.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $query = $conn->query("SELECT * FROM admin WHERE email='$email' AND password='$pass'");
    if ($query->num_rows > 0) {
        $_SESSION['admin'] = $email;
        header("Location: admin_dashboard.php");
    } else {
        echo "Incorrect credentials";
    }
}
?>

<form method="post">
    <input type="email" name="email" placeholder="Admin Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>
