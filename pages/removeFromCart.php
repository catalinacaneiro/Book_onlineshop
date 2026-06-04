<?php
require_once(__DIR__ . "/../config/database.php");
require_once(__DIR__ . "/../repositories/cartRepository.php");
require_once(__DIR__ . "/../Models/cart.php");

$productIdToRemove = $_GET['id'] ?? null;

if ($productIdToRemove === null) {
    header("Location: /viewCart");
    exit;
}

$db = new Database();
$cartRepository = new CartRepository($db->pdo);
$cart = new Cart($cartRepository, session_id());
$cart->removeItem($productIdToRemove, 1);

$fromPage = urldecode($_GET['fromPage'] ?? '/viewCart');
header("Location: $fromPage");
exit;
?>