<?php
require_once("../vendor/autoload.php");
require_once("__DIR__.'/Models/cart.php");
require_once("__DIR__.'/Models/cart_item.php");
require_once("__DIR__.'/repositories/cartRepository.php");
require_once("__DIR__.'/repositories/userRepository.php");


$db = new Database(); 
$cart = new Cart($db)


// skapar array med line items som stripe dera APIet kräver. 
//$lineitems = [];
// foreach($->getItems()) as $cartitem 
?>






<aside class="cart-summary" aria-label="Basket totals">
    <h2>Basket totals</h2>
    <div class="cart-summary-line">
        <span>Shipment</span>
        <span>Shipping costs are calculated during checkout.</span>
    </div>
    <div class="cart-summary-line cart-summary-total">
        <span>Total</span>
        <span id="cartTotalPrice"><?php echo number_format((float) $cartTotal, 0, ",", " "); ?> kr</span>
    </div>
    <a href="/checkout" class="cart-checkout-btn">Proceed to checkout</a>
</aside>