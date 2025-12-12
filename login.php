<?php
session_start();
require 'db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // ✅ Store user session info
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user'] = [
                'id' => $id,
                'name' => $name,
                'email' => $email
            ];

            // ✅ Redirect to dashboard
            header("Location: user_dashboard.php");
            exit;
        } else {
            $message = "❌ Incorrect password.";
        }
    } else {
        $message = "⚠️ No account found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | GIOIELLO</title>
  <link rel="stylesheet" href="relog.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="nav">
    <div class="brand-container">
      <img src="1.jpg" alt="Gioiello Logo" class="brand-logo">
      <div class="brand">GIOIELLO</div>
    </div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="#customize">Customize</a></li>
      <li><a href="view_cart.php">Cart (<?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>)</a></li>
      <?php if(isset($_SESSION['user'])): ?>
          <li><a href="user_dashboard.php">Hi, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></a></li>
          <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
          <li><a href="register.php">Register</a></li>
          <li><a href="login.php" class="active">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <main class="page-main">
    <div class="form-container">
      <h2>Welcome Back</h2>
      <?php if ($message): ?>
        <p class="msg"><?= $message ?></p>
      <?php endif; ?>
      <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p>Don’t have an account? <a href="register.php">Register now</a></p>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Gioiello. All rights reserved.</p>
    <div>
      Follow us:
      <a href="https://www.instagram.com/gi0iell0_?igsh=dmUwYTJrN2cyODFx" target="_blank">Instagram</a> |
      <a href="https://wa.me/+92 300 0973300" target="_blank">WhatsApp</a> |
      <a href="https://www.tiktok.com/@gi0iell0_?_t=ZS-90bKP4SMCGm&_r=1" target="_blank">TikTok</a>
    </div>
  </footer>
</body>
</html>