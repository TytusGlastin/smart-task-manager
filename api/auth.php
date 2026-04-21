<?php
session_start();
require_once "../config/db.php";

$action = $_POST['action'] ?? '';

if ($action === "register") {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Hash password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $hashedPassword);

  if ($stmt->execute()) {
    echo "Registered successfully";
  } else {
    echo "Error: " . $stmt->error;
  }

}

elseif ($action === "login") {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // Verify password
  if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    header("Location: ../public/dashboard.php");
    exit;

  } else {
    echo "Invalid credentials";
  }

}
?>