<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../Models/cart.php');
require_once(__DIR__ . '/../repositories/cartRepository.php');

$db = new Database();
$cartRepository = new CartRepository($db->pdo);
$cart = new Cart($cartRepository, session_id());

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'cartItemCount' => $cart->getItemsCount(),
    'cartTotalPrice' => $cart->getTotalPrice(),
    'cartItems' => $cart->getItems(),
]);
