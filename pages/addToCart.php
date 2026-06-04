<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../Models/cart.php');
require_once(__DIR__ . '/../repositories/cartRepository.php');

$productIdAddToCart = $_GET['id'] ?? null;

if ($productIdAddToCart === null) {
    header("Location: /viewCart");
    exit;
}

$db = new Database();
$cartRepository = new CartRepository($db->pdo);
$cart = new Cart($cartRepository, session_id());

$cart->addItem($productIdAddToCart, 1);

$fromPage = urldecode($_GET['fromPage'] ?? '/');
header("Location: $fromPage");
exit;

?>