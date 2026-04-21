<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="layout">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <h2>TaskApp</h2>
    <div class = "menu-label">
        <a href="dashboard.php"> Dashboard</a>
    </div>
    <div class = "menu-label">
        <a href="logout.php"> Logout</a>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">

    <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>

    <!-- STATS -->
    <div class="stats">
      <div id="total">Total: 0</div>
      <div id="pending">Pending: 0</div>
      <div id="completed">Completed: 0</div>
    </div>

    <!-- INPUT -->
    <div class="input-box">
      <input id="taskInput" placeholder="Enter task..." />
      <button onclick="addTask()">Add</button>
    </div>

    <!-- FILTER -->
    <div class="filters">
      <input id="search" placeholder="Search..." oninput="loadTasks()">
      <select id="status" onchange="loadTasks()">
        <option value="">All</option>
        <option value="pending">Pending</option>
        <option value="completed">Completed</option>
      </select>
    </div>

    <!-- TASKS -->
    <div id="tasks" class="task-container"></div>

  </div>

</div>

<script>
async function loadStats() {
  const res = await fetch("../api/tasks.php?action=stats");
  const data = await res.json();

  document.getElementById("total").innerText = "Total: " + data.total;
  document.getElementById("pending").innerText = "Pending: " + data.pending;
  document.getElementById("completed").innerText = "Completed: " + data.completed;
}

async function loadTasks() {
  const search = document.getElementById("search").value;
  const status = document.getElementById("status").value;

  const res = await fetch(`../api/tasks.php?action=list&search=${search}&status=${status}`);
  const data = await res.json();

  let html = "";

  data.forEach(t => {
    html += `
      <div class="task">
        <h3>${t.title}</h3>
        <span class="status ${t.status}">${t.status}</span>

        <div>
          <button class="done-btn" onclick="completeTask(${t.id})">Done</button>
          <button class="delete-btn" onclick="deleteTask(${t.id})">Delete</button>
        </div>
      </div>
    `;
  });

  document.getElementById("tasks").innerHTML = html;
}

async function addTask() {
  const title = document.getElementById("taskInput").value;

  await fetch("../api/tasks.php", {
    method: "POST",
    body: new URLSearchParams({
      action: "add",
      title: title
    })
  });

  loadTasks();
  loadStats();
}

async function completeTask(id) {
  await fetch("../api/tasks.php", {
    method: "POST",
    body: new URLSearchParams({
      action: "complete",
      id: id
    })
  });

  loadTasks();
  loadStats();
}

async function deleteTask(id) {
  await fetch("../api/tasks.php", {
    method: "POST",
    body: new URLSearchParams({
      action: "delete",
      id: id
    })
  });

  loadTasks();
  loadStats();
}

loadTasks();
loadStats();
</script>

</body>
</html>