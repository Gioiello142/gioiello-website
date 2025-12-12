CREATE DATABASE IF NOT EXISTS gioiello CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gioiello;


-- users
CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(150) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
phone VARCHAR(30),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- products
CREATE TABLE IF NOT EXISTS products (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(150) NOT NULL,
description TEXT,
price DECIMAL(10,2) NOT NULL,
image VARCHAR(255) DEFAULT 'placeholder.jpg',
is_medicated TINYINT(1) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- orders
CREATE TABLE IF NOT EXISTS orders (
id INT AUTO_INCREMENT PRIMARY KEY,
'product_id' => $product['id'],
customer_name VARCHAR(150) NOT NULL,
phone VARCHAR(50) NOT NULL,
email VARCHAR(150) NOT NULL,
address TEXT NOT NULL,
total DECIMAL(10,2) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- order items
CREATE TABLE IF NOT EXISTS order_items (
id INT AUTO_INCREMENT PRIMARY KEY,
order_id INT NOT NULL,
product_id INT NOT NULL,
qty INT NOT NULL,
price DECIMAL(10,2) NOT NULL,
FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;


-- sample products
INSERT INTO products (name, description, price, image, is_medicated) VALUES
('Classic Afghani Jhumka', 'Handcrafted Afghani jhumka with traditional motifs.', 25.00, 'images/j1.jpg', 1),
('Silver Filigree Jhumka', 'Elegant silver filigree design.', 30.00, 'images/j2.jpg', 0),
('Polished Brass Jhumka', 'Lightweight polish brass pair.', 18.50, 'images/j3.jpg', 0);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(30),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;