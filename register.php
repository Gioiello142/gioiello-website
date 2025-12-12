<?php
session_start();
require 'db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $check = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "⚠️ Email already registered.";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $phone);
        if ($stmt->execute()) {
            $message = "✅ Registration successful! You can now login.";
        } else {
            $message = "❌ Error: " . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | GIOIELLO</title>
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
          <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <main class="page-main">
  <div class="form-container">
    <h2>Create an Account</h2>
    <?php if ($message): ?>
      <p class="msg"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <input type="password" name="password" placeholder="Create Password" required>
      <button type="submit">Register</button>
      <p>Already have an account? <a href="login.php">Login here</a></p>
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