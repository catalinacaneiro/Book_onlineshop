<?php
require_once(__DIR__ . '/../Models/database.php');
require_once(__DIR__ . '/../Models/cart.php');
require_once(__DIR__ . '/../Models/cartItem.php');

$productIdAddToCart = $_GET['id'];

$db = new Database();
$cart = new Cart($db, session_id());

$cart->addItem($productIdAddToCart, 1);

echo "Add to cart ... ";



?>