<?php
require_once("config/database.php");
require_once("repositories/cartRepository.php");
require_once("Models/cart.php");

$db = new Database();
$cartRepository = new CartRepository($db->pdo);
$cart = new Cart($cartRepository, session_id());
$cartItems = $cart->getItems();
$antalICarten = $cart->getItemsCount();
$cartTotal = $cart->getTotalPrice();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Your Cart</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <?php require_once("components/nav.php"); ?>
    </nav>

    <main class="cart-page">
        <section class="cart-layout container px-4 px-lg-5">
            <div class="cart-main">
                <h1 class="cart-title">Cart</h1>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="cartItem">
                        <?php if (empty($cartItems)) { ?>
                            <tr>
                                <td colspan="3" class="cart-empty">Your cart is empty.</td>
                            </tr>
                        <?php } ?>

                        <?php foreach ($cartItems as $item) {
                            $imagePath = trim((string) ($item->img ?? ""));
                            $rowTotal = (float) ($item->rowPrice ?? 0);
                            $addLink = "/addToCart?id=" . urlencode((string) $item->product_id) . "&fromPage=" . urlencode("/viewCart");
                            $removeLink = "/removeFromCart?id=" . urlencode((string) $item->product_id) . "&fromPage=" . urlencode("/viewCart");
                            ?>
                            <tr>
                                <td>
                                    <div class="cart-product">
                                        <div class="cart-thumb-wrap">
                                            <?php if ($imagePath !== "") { ?>
                                                <img class="cart-thumb" src="<?php echo htmlspecialchars($imagePath); ?>"
                                                    alt="<?php echo htmlspecialchars((string) $item->title); ?>">
                                            <?php } else { ?>
                                                <div class="cart-thumb cart-thumb-placeholder">No image</div>
                                            <?php } ?>
                                        </div>
                                        <div class="cart-product-title">
                                            <?php echo htmlspecialchars((string) $item->title); ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-quantity">
                                        <a href="<?php echo htmlspecialchars($removeLink); ?>" class="qty-btn"
                                            onclick="removeFromCart(<?php echo (int) $item->product_id; ?>); return false;"
                                            aria-label="Decrease quantity">-</a>
                                        <span><?php echo (int) $item->quantity; ?></span>
                                        <a href="<?php echo htmlspecialchars($addLink); ?>" class="qty-btn"
                                            onclick="addToCart(<?php echo (int) $item->product_id; ?>); return false;"
                                            aria-label="Increase quantity">+</a>
                                    </div>
                                </td>
                                <td class="cart-subtotal">$<?php echo number_format($rowTotal, 0, ",", " "); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="cart-update-wrap">
                    <a href="/viewCart" class="cart-update-btn">Update basket</a>
                </div>
            </div>

            

            <aside class="cart-summary" aria-label="Basket totals">
                <h2>Basket totals</h2>
                <div class="cart-summary-line">
                    <span>Shipment</span>
                    <span>Shipping costs are calculated during checkout.</span>
                </div>
                <div class="cart-summary-line cart-summary-total">
                    <span>Total</span>
                    <span id="cartTotalPrice">$<?php echo number_format((float) $cartTotal, 0, ",", " "); ?></span>
                </div>
                <a href="/checkout" class="cart-checkout-btn">Proceed to checkout</a>
            </aside>
        </section>
    </main>

    <?php require_once("components/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>

</html>