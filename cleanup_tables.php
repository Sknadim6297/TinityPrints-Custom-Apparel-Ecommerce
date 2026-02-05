<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tinnity_ecom', 'root', '');
$pdo->exec('DROP TABLE IF EXISTS product_images');
$pdo->exec('DROP TABLE IF EXISTS product_colors');
$pdo->exec('DROP TABLE IF EXISTS product_sizes');
$pdo->exec('DROP TABLE IF EXISTS products');
echo "Tables dropped successfully\n";
?>
