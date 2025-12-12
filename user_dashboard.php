<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $mysqli->prepare("SELECT name, email, phone, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Ensure consistent header greeting structure
if (!isset($_SESSION['user']) && $user) {
  $_SESSION['user'] = [
    'id' => $user_id,
    'name' => $user['name'],
    'email' => $user['email']
  ];
}

// Fetch orders
$order_stmt = $mysqli->prepare("SELECT * FROM orders WHERE email = ? ORDER BY created_at DESC");
$order_stmt->bind_param("s", $user['email']);
$order_stmt->execute();
$orders = $order_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard | GIOIELLO</title>
  <link rel="stylesheet" href="dashboard.css">
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

  <div class="dashboard-container">
    <h2>Welcome, <?= htmlspecialchars($user['name']); ?> 👋</h2>

    <div class="user-info">
      <h3>Your Profile</h3>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
      <p><strong>Member Since:</strong> <?= date("d M Y", strtotime($user['created_at'])); ?></p>
    </div>

    <div class="order-history">
      <h3>Your Order History</h3>
      <?php if ($orders->num_rows > 0): ?>
        <?php while ($order = $orders->fetch_assoc()): ?>
          <div class="order-box">
            <h4>Order #<?= $order['id']; ?> — <?= date("d M Y", strtotime($order['created_at'])); ?></h4>
            <p><strong>Total:</strong> Rs. <?= number_format($order['total'], 2); ?></p>

            <?php
              $items_stmt = $mysqli->prepare("
                SELECT p.name, oi.qty, oi.price 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?
              ");
              $items_stmt->bind_param("i", $order['id']);
              $items_stmt->execute();
              $items = $items_stmt->get_result();
            ?>

            <table class="order-items">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Price (Rs.)</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($item = $items->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= $item['qty']; ?></td>
                    <td><?= number_format($item['price'], 2); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="no-orders">You haven’t placed any orders yet.</p>
      <?php endif; ?>
    </div>

    <div class="logout-section">
      <a href="logout.php" class="btn-logout">Logout</a>
      <a href="index.php" class="btn-logout" style="margin-left:10px; background-color:#555;">Go to Home</a>
    </div>
  </div>

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