<?php
session_start();
require 'db.php';

// fetch products
$res = $mysqli->query("SELECT * FROM products ORDER BY created_at DESC");
$products = [];
while ($row = $res->fetch_assoc()) $products[] = $row;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Products — Gioiello</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="nav">
	<div class="brand-container">
		<img src="1.jpg" alt="Gioiello Logo" class="brand-logo">
		<div class="brand">GIOIELLO</div>
	</div>
	<ul class="nav-links">
		<li><a href="index.php">Home</a></li>
		<li><a href="products.php" aria-current="page">Products</a></li>
		<li><a href="index.php#customize">Customize</a></li>
		<li><a href="view_cart.php">Cart (<?php echo isset($_SESSION['cart'])? array_sum(array_column($_SESSION['cart'], 'qty')):0; ?>)</a></li>
		<?php if(isset($_SESSION['user'])): ?>
			<li><a href="#">Hi, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></a></li>
			<li><a href="logout.php">Logout</a></li>
		<?php else: ?>
            <li><a href="register.php">Register</a></li>
			<li><a href="login.php">Login</a></li>
		<?php endif; ?>
	</ul>
</nav>

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
<div class="products-grid">
<?php foreach($products as $p): ?>
	<div class="product-card">
		<img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
		<h3><?php echo htmlspecialchars($p['name']); ?></h3>
		<p><?php echo htmlspecialchars($p['description']); ?></p>
        
		<div class="price">Rs. <?php echo number_format($p['price'],2); ?></div>

		<form action="add_to_cart.php" method="post" class="product-actions">
			<input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
			<input type="number" name="qty" value="1" min="1" max="50">
			<button type="submit" class="btn-small">Add to Cart</button>
		</form>

		<?php if($p['is_medicated']): ?>
			<div class="badge">Medicated option available</div>
		<?php endif; ?>
	</div>
<?php endforeach; ?>
</div>
</main>

<footer class="footer">
	<p>&copy; <?php echo date('Y'); ?> Gioiello. All rights reserved.</p>
	<div>Follow us: 
		<a href="https://www.instagram.com/gi0iell0_?igsh=dmUwYTJrN2cyODFx" target="_blank">Instagram</a> | 
		<a href="https://wa.me/+92 300 0973300" target="_blank">WhatsApp</a> | 
		<a href="https://www.tiktok.com/@gi0iell0_?_t=ZS-90bKP4SMCGm&_r=1" target="_blank">TikTok</a>
	</div>
</footer>
</body>
</html>
