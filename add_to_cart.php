<?php
session_start();
require 'db.php';


$product_id = isset($_POST['product_id'])? (int)$_POST['product_id']:0;
$qty = isset($_POST['qty'])? (int)$_POST['qty']:1;


if ($product_id <=0) {
header('Location: index.php'); exit;
}


// fetch product
$stmt = $mysqli->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows == 0) { header('Location: index.php'); exit; }
$product = $res->fetch_assoc();


if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];


// if exists increment
$found = false;
foreach ($_SESSION['cart'] as &$item) {
	if (isset($item['product_id']) && $item['product_id'] == $product_id) { $item['qty'] += $qty; $found = true; break; }
}
if (!$found) {
$_SESSION['cart'][] = [
	'product_id' => (int)$product['id'],
	'name' => $product['name'],
	'price' => (float)$product['price'],
	'image' => isset($product['image']) ? $product['image'] : '1.jpg',
	'qty' => (int)$qty
];
}


header('Location: view_cart.php');
exit;