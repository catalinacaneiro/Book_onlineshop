<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../Models/cart.php');
require_once(__DIR__ . '/../repositories/cartRepository.php');

$productIdToRemove = $_GET['id'] ?? null;

if ($productIdToRemove === null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Missing product id'
    ]);
    exit;
}

$db = new Database();
$cartRepository = new CartRepository($db->pdo);
$cart = new Cart($cartRepository, session_id());
$cart->removeItem($productIdToRemove, 1);

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => "Product $productIdToRemove removed from cart",
    'cartItemCount' => $cart->getItemsCount(),
    'cartTotalPrice' => $cart->getTotalPrice(),
    'cartItems' => $cart->getItems(),
]);
