<?php
session_start();
require 'db.php';

// Ensure cart exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// fetch products
$res = $mysqli->query("SELECT * FROM products ORDER BY created_at DESC");
$products = [];

// Remove item from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $idx = (int)$_POST['remove'];
    if (isset($cart[$idx])) {
        unset($cart[$idx]); // safer than array_splice
        $_SESSION['cart'] = array_values($cart); // reindex array
    }
    header('Location: view_cart.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Your Cart - Gioiello</title>
  <link rel="stylesheet" href="styles.css">
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

  <!-- Main content -->
  <main class="container">
    <h1 style="
        font-size: 2.6rem;
        letter-spacing: 3px;
        margin-bottom: 20px;
        text-align: center;
        color: #F8437FFF;
        font-weight: bold;
    "> <br>
        Our Jhumkas
    </h1>

    <?php if(empty($cart)): ?>
      <div style="min-height:50vh; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
        <p style="font-size:18px; color:#444; font-weight:bold; margin-bottom:16px;">Your cart is empty.</p>
        <a href="products.php" style="background-color:#ff4081; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:600; transition:0.3s;">Continue shopping</a>
      </div>
    <?php else: ?>
      <p style="font-size:17px; color:#444; margin-bottom:10px; margin-left:36px; font-weight:bold;">Don’t stop here—explore our stunning Afghani Jhumka collection and find your next favorite pair!</p>
      <a href="products.php" style="background-color:#ff4081; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:600; transition:0.3s; margin-left:32px;">Continue Shopping</a>
      <div class="products-grid">
        <?php 
        $total = 0; 
        foreach($cart as $i => $it): 
            $sub = $it['price'] * $it['qty']; 
            $total += $sub; 
        ?>
    <div class="product-card">
  <img src="<?php echo htmlspecialchars(isset($it['image']) ? $it['image'] : '1.jpg'); ?>" alt="<?php echo htmlspecialchars($it['name']); ?>">
  
  <h3><?php echo htmlspecialchars($it['name']); ?></h3>
  <p>Qty: <?php echo $it['qty']; ?></p>
  <div class="price">Rs. <?php echo number_format($it['price'], 2); ?></div>
  <div class="price">Subtotal: Rs. <?php echo number_format($sub, 2); ?></div>
  
  <form method="post" class="product-actions">
    <button type="submit" name="remove" value="<?php echo $i; ?>" class="btn-remove">Remove</button>
  </form>
</div>
        <?php endforeach; ?>
      </div>

      <h3 style="font-size:20px; color:#444; margin-bottom:10px; margin-left:36px; font-weight:bold;">Grand Total: Rs. <?php echo number_format($total,2); ?></h3>
      <a href="place_order.php" style="background-color:#ff4081; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:600; transition:0.3s; margin-left:32px;">Place Order</a>
    <?php endif; ?>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Gioiello. All rights reserved.</p>
    <div>
      Follow us:
      <a href="https://instagram.com/your_instagram" target="_blank">Instagram</a> |
      <a href="https://wa.me/+92 300 0973300" target="_blank">WhatsApp</a> |
      <a href="https://www.tiktok.com/@gi0iell0_?_t=ZS-90bKP4SMCGm&_r=1" target="_blank">TikTok</a>
    </div>
  </footer>
</body>
</html>
