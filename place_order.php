<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Fetch user info
$stmt_user = $mysqli->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

$user_name = $user_data['name'] ?? '';
$user_email = $user_data['email'] ?? '';
$user_phone = $user_data['phone'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);

  // Calculate total
  $total = 0;
  foreach ($cart as $item) {
      $total += $item['price'] * $item['qty'];
  }

  // Insert into orders
  $stmt = $mysqli->prepare("INSERT INTO orders (customer_name, phone, email, address, total) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssd", $name, $phone, $email, $address, $total);
  $stmt->execute();
  $order_id = $stmt->insert_id;
  $stmt->close();

  // Insert each cart item into order_items
  $stmt_item = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, qty, price) VALUES (?, ?, ?, ?)");
  foreach ($cart as $item) {
    $pid = isset($item['product_id']) ? (int)$item['product_id'] : 0;
    $qtyItem = isset($item['qty']) ? (int)$item['qty'] : 0;
    $priceItem = isset($item['price']) ? (float)$item['price'] : 0.0;
    if ($pid <= 0 || $qtyItem <= 0) continue;
    $stmt_item->bind_param("iiid", $order_id, $pid, $qtyItem, $priceItem);
    $stmt_item->execute();
  }
  $stmt_item->close();

  // Clear cart
  unset($_SESSION['cart']);

  // Redirect to success page
  header("Location: order_success.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Place Your Order - Gioiello</title>
<link rel="stylesheet" href="order_style.css">
</head>
<body>
  <div class="order-container">
    <h2>Complete Your Order</h2>
    <form method="POST">
      <label>Full Name:</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($user_name); ?>" required>

      <label>Email:</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required>

      <label>Phone Number:</label>
      <input type="text" name="phone" value="<?php echo htmlspecialchars($user_phone); ?>" required>

      <label>Shipping Address:</label>
      <textarea name="address" rows="3" placeholder="Enter your full shipping address" required></textarea>

      <button type="submit" class="btn-submit">Confirm Order</button>
    </form>
  </div>
</body>
</html>