<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../Models/cart.php");
require_once(__DIR__ . "/../Models/cart_item.php");
require_once(__DIR__ . "/../repositories/cartRepository.php");
require_once(__DIR__ . "/../repositories/userRepository.php");


$db = new Database();
$cartRepository = new CartRepository($db->getPdo());
$cart = new Cart($cartRepository, session_id());
$cartItems = $cart->getItems();

foreach ($cartItems as $cartItem) {
    $query = $db->getPdo()->prepare("
    UPDATE products
    SET stock_quantity = stock_quantity - :qty
    WHERE id = :product_id
    AND stock_quantity >= :qty
    "); 

    $query->execute([
        'qty' => $cartItem->quantity,
        'product_id' => $cartItem->product_id
    ]);

    if ($query->rowCount() !== 1){
        throw new Exception("One or more products are out of stock or have insufficient stock.");
    }
}

\Stripe\Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

$lineitems = [];
foreach ($cart->getItems() as $cartItem) {
    array_push($lineitems, [
        "quantity" => $cartItem->quantity,
        "price_data" => [
            "currency" => "sek",
            "unit_amount" => $cartItem->price * 100,
            "product_data" => [
                "name" => $cartItem->title
            ]
        ]
    ]);
}

array_push($lineitems, [
    "quantity" => 1,
    "price_data" => [
        "currency" => "sek",
        "unit_amount" => 500, 
        "product_data" => [
            "name" => "Fraktkostnad"
        ]
    ]
]);

//stoppa in en till lineitem som är fraktkostnaden 

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/checkoutSuccess?session_id={CHECKOUT_SESSION_ID}",
    "cancel_url" => "http://localhost:8000",
    "locale" => "auto",
    "line_items" => $lineitems
]);

http_response_code(303);
header("Location: " . $checkout_session->url);

?>