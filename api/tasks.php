<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
  echo "Unauthorized";
  exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';


// ➤ CREATE TASK
if ($action === "add") {

  $title = $_POST['title'];

  $stmt = $conn->prepare("INSERT INTO tasks (title, user_id) VALUES (?, ?)");
  $stmt->bind_param("si", $title, $user_id);
  $stmt->execute();

  echo "Task added";
}


// ➤ GET TASKS
elseif ($action === "list") {

  $search = $_GET['search'] ?? '';
  $status = $_GET['status'] ?? '';

  $query = "SELECT * FROM tasks WHERE user_id=?";
  
  if ($search) {
    $query .= " AND title LIKE ?";
  }

  if ($status) {
    $query .= " AND status=?";
  }

  $stmt = $conn->prepare($query);

  if ($search && $status) {
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("iss", $user_id, $searchParam, $status);
  } elseif ($search) {
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("is", $user_id, $searchParam);
  } elseif ($status) {
    $stmt->bind_param("is", $user_id, $status);
  } else {
    $stmt->bind_param("i", $user_id);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  $tasks = [];

  while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
  }

  echo json_encode($tasks);
}


// ➤ MARK COMPLETE
elseif ($action === "complete") {

  $id = $_POST['id'];

  $stmt = $conn->prepare("UPDATE tasks SET status='completed' WHERE id=? AND user_id=?");
  $stmt->bind_param("ii", $id, $user_id);
  $stmt->execute();

  echo "Task completed";
}


// ➤ DELETE TASK
elseif ($action === "delete") {

  $id = $_POST['id'];

  $stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
  $stmt->bind_param("ii", $id, $user_id);
  $stmt->execute();

  echo "Task deleted";
}

elseif ($action === "stats") {

  $stmt1 = $conn->prepare("SELECT COUNT(*) as total FROM tasks WHERE user_id=?");
  $stmt1->bind_param("i", $user_id);
  $stmt1->execute();
  $total = $stmt1->get_result()->fetch_assoc();

  $stmt2 = $conn->prepare("SELECT COUNT(*) as pending FROM tasks WHERE user_id=? AND status='pending'");
  $stmt2->bind_param("i", $user_id);
  $stmt2->execute();
  $pending = $stmt2->get_result()->fetch_assoc();

  $stmt3 = $conn->prepare("SELECT COUNT(*) as completed FROM tasks WHERE user_id=? AND status='completed'");
  $stmt3->bind_param("i", $user_id);
  $stmt3->execute();
  $completed = $stmt3->get_result()->fetch_assoc();

  echo json_encode([
    "total" => $total['total'],
    "pending" => $pending['pending'],
    "completed" => $completed['completed']
  ]);
}
?>