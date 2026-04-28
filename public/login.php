<?php
session_start();

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="auth-container">

  <h1 class="title">Login</h1>

  <form action="../api/auth.php" method="POST" class="auth-form">

    <input type="hidden" name="action" value="login">

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <input 
      type="email" 
      name="email" 
      placeholder="Email" 
      required
    >

    <input 
      type="password" 
      name="password" 
      placeholder="Password" 
      required
    >

    <button type="submit">Login</button>

  </form>

  <p class="switch">
    Don’t have an account?
    <a href="register.php">Register</a>
  </p>

</div>

</body>
</html>