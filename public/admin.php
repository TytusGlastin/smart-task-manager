<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  die("Access denied");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<h1 class="title">Admin Dashboard</h1>

<div class="stats">
  <div id="users">Users: 0</div>
  <div id="tasks">Tasks: 0</div>
  <div id="pending">Pending: 0</div>
  <div id="completed">Completed: 0</div>
</div>

<h2>All Tasks</h2>
<div id="taskList"></div>

<a href="logout.php" class="logout">Logout</a>

<script>
async function loadAdminStats() {
  const res = await fetch("../api/admin.php?action=stats");
  const data = await res.json();

  if (data.error) {
    console.error("API error:", data.error);
    return;
  }

  document.getElementById("users").innerText = "Users: " + data.users;
  document.getElementById("tasks").innerText = "Tasks: " + data.tasks;
  document.getElementById("pending").innerText = "Pending: " + data.pending;
  document.getElementById("completed").innerText = "Completed: " + data.completed;
}

async function loadTasks() {
  const res = await fetch("../api/admin.php?action=tasks");
  const data = await res.json();

  let html = "";

  data.forEach(t => {
    html += `
      <div class="task">
        <b>${t.title}</b><br>
        User: ${t.name}<br>
        Status: ${t.status}
      </div>
    `;
  });

  document.getElementById("taskList").innerHTML = html;
}

loadAdminStats();
loadTasks();
</script>

</body>
</html>