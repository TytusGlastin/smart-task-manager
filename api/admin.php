<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo json_encode(["error" => "unauthorized"]);
  exit;
}

$action = $_GET['action'] ?? '';

if ($action === "stats") {

  $users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
  $tasks = $conn->query("SELECT COUNT(*) as c FROM tasks")->fetch_assoc()['c'];
  $pending = $conn->query("SELECT COUNT(*) as c FROM tasks WHERE status='pending'")->fetch_assoc()['c'];
  $completed = $conn->query("SELECT COUNT(*) as c FROM tasks WHERE status='completed'")->fetch_assoc()['c'];

  echo json_encode([
    "users" => $users,
    "tasks" => $tasks,
    "pending" => $pending,
    "completed" => $completed
  ]);
  exit;
}

if ($action === "tasks") {

  $query = "
    SELECT tasks.title, tasks.status, users.name
    FROM tasks
    JOIN users ON users.id = tasks.user_id
    ORDER BY tasks.id DESC
  ";

  $result = $conn->query($query);

  $data = [];

  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }

  echo json_encode($data);
  exit;
}