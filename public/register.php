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
  <title>Register</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="auth-container">

  <h1 class="title">Register</h1>

  <form action="../api/auth.php" method="POST" class="auth-form">

    <input type="hidden" name="action" value="register">

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <input 
      type="text" 
      name="name" 
      placeholder="Full Name" 
      required
    >

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

    <button type="submit">Create Account</button>

  </form>

  <p class="switch">
    Already have an account?
    <a href="login.php">Login</a>
  </p>

</div>

</body>
</html>