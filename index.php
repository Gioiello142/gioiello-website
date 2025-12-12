<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gioiello — Jhumkas</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="nav">
    <div class="brand-container">
        <img src="1.jpg" alt="Gioiello Logo" class="brand-logo"> <!-- Brand logo -->
        <div class="brand">GIOIELLO</div>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
         <li><a href="products.php">Products</a></li>
        <li><a href="#customize">Customize</a></li>
        <li><a href="view_cart.php">Cart (<?php echo isset($_SESSION['cart'])? array_sum(array_column($_SESSION['cart'], 'qty')):0; ?>)</a></li>
        <?php if(isset($_SESSION['user'])): ?>
            <li><a href="user_dashboard.php">Hi, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
           
        <?php endif; ?>
    </ul>
</nav>

<main class="container">
<section class="hero" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px; padding: 60px 5%; background-color: #fffafc;">
  
  <!-- Left side: text -->
  <div style="flex: 1 1 50%; min-width: 300px;">
    <h1 style="color: #ff4081; font-size: 38px; margin-bottom: 15px; letter-spacing: 1px;">WELCOME TO GIOIELLO</h1>
    <p style="font-size: 17px; color: #333; line-height: 1.8; text-align: justify; margin-bottom: 25px;">
      Gioiello is a handcrafted jewelry brand that brings the charm of traditional Afghani jhumkas into modern fashion. 
      Each pair is designed with fine detailing, vibrant colors, and high-quality materials to ensure both beauty and comfort. 
      Our jhumkas stand out for their lightweight build, long-lasting shine, and skin-friendly materials that make them safe for everyday wear. 
      What makes Gioiello unique is our medicated jhumka collection — specially designed for those with sensitive ears, ensuring style without irritation. 
      With a focus on elegance, comfort, and craftsmanship, Gioiello offers jewelry that complements every outfit and occasion.
    </p>
    <a href="products.php" style="background-color:#ff4081; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:600; transition:0.3s;">Explore Our Products</a>
  </div>

  <!-- Right side: image -->
  <div style="flex: 1 1 40%; min-width: 300px; text-align:center;">
    <img src="p1.jpg" alt="Gioiello Jhumkas" style="width:100%; max-width:420px; border-radius:20px; box-shadow:0 4px 10px rgba(0,0,0,0.15);">
  </div>
</section>

<section id="customize" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:40px; background-color:#fdf2f4; padding:50px 5%; border-radius:12px; margin-top:60px;">

  <!-- LEFT SIDE: TEXT -->
  <div style="flex:1 1 50%; min-width:300px;">
    <h2 style="color: #ff4081; font-size:30px; margin-bottom:15px;">Want to customize or add medicated jhumkas?</h2>
    <p style="font-size:17px; color:#444; line-height:1.8; text-align:justify; margin-bottom:20px;">
     At Gioiello, we believe every pair of jhumkas should reflect your style and story. That’s why we offer complete customization options — from choosing your favorite color combinations, bead styles, and metal finishes to selecting lightweight or statement designs. You can even send us a reference picture or share your creative idea, and our artisans will handcraft your dream pair with precision. Whether you prefer traditional Afghani charm or a modern twist, our customization process ensures that every detail matches your personality. Each piece is made on order, taking about 5–7 working days depending on the complexity, so you receive jewelry that’s uniquely yours.
    </p>
    <p style="font-size:17px; color:#444; line-height:1.8; text-align:justify; margin-bottom:20px;">
   Our medicated jhumkas are specially designed for customers with sensitive skin or metal allergies. These earrings are made using nickel-free, hypoallergenic materials that are gentle on your ears and safe for daily wear. To provide extra comfort, each medicated jhumka set comes with a small lotion packet that helps reduce irritation or rashes caused by prolonged use of regular metal earrings. The medicated coating acts as a barrier between your skin and the metal, keeping your ears healthy and rash-free while maintaining the same shine and beauty as our classic designs.
    </p>
    <p style="font-size:17px; color:#444; margin-bottom:25px;">
      To place a customization request, simply contact us on your preferred platform below — our team will guide you step-by-step:
    </p>
    <div style="display:flex; gap:15px; flex-wrap:wrap;">
      <a href="https://wa.me/+92 300 0973300" target="_blank" style="background-color:#25D366; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none;">WhatsApp</a>
      <a href="https://www.instagram.com/gi0iell0_?igsh=dmUwYTJrN2cyODFx" target="_blank" style="background-color:#E4405F; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none;">Instagram</a>
      <a href="https://www.tiktok.com/@gi0iell0_?_t=ZS-90bKP4SMCGm&_r=1" target="_blank" style="background-color:#000; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none;">TikTok</a>
    </div>
  </div>

  <!-- RIGHT SIDE: IMAGE -->
  <div style="flex:1 1 40%; min-width:300px; text-align:center;">
    <img src="p3.jpg" alt="Customize Your Jhumkas" style="width:100%; max-width:420px; border-radius:20px; box-shadow:0 4px 10px rgba(0,0,0,0.15);">
  </div>

</section>
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