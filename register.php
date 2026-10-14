<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'connect.php';

$student_number = $_POST['student_number'] ?? '';
$university = $_POST['university'] ?? '';

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'] ?? '';
    $lastName = $_POST['lName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = md5($_POST['password'] ?? '');

    // Check if email exists manually
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result(); // ✅ instead of get_result()

    if ($stmt->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users(firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
        if ($stmt->execute()) {
            // Insert into user_info
            $stmt2 = $conn->prepare("INSERT INTO user_info(email, student_number, university) VALUES (?, ?, ?)");
            $stmt2->bind_param("sss", $email, $student_number, $university);
            $stmt2->execute();

            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// LOGIN
if (isset($_POST['signIn'])) {
    $email = $_POST['email'] ?? '';
    $password = md5($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT email FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result(); // ✅ use store_result

    if ($stmt->num_rows > 0) {
        session_start();
        $_SESSION['email'] = $email;
        header("Location: homepage.php");
        exit();
    } else {
        // Check admin
        $stmt = $conn->prepare("SELECT email FROM admin WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['admin'] = true;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Not Found, Incorrect Email or Password";
        }
    }
}
?>
