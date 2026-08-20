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
    <title>View Cart</title>
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


                <label for="currencyFrom" class="form-label">
                    From
                </label>

                <select id="currencyFrom" class="form-select mb-3">
                    <option value="USD" selected>USD</option>
                    <option value="SEK">SEK</option>
                    <option value="EUR">EUR</option>
                </select>


                <label for="currencyTo" class="form-label">
                    To
                </label>

                <select id="currencyTo" class="form-select mb-3">
                    <option value="SEK" selected>SEK</option>
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                </select>
                <div class="cart-summary-line cart-summary-total">
                    <span>Total</span>
                    <span id="cartTotalPrice" data-amount="<?php echo (float) $cartTotal; ?>">
                        $<?php echo number_format((float) $cartTotal, 0, ",", " "); ?>
                    </span>
                </div>
                <a href="/checkout" class="cart-checkout-btn">Proceed to checkout</a>
            </aside>
        </section>
    </main>

    <?php require_once("components/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>


    <script>
        const APP_ID = "c59f8927e5894eb29b56316d562e85c8";
        let rates = null;

        const fromEl = document.getElementById("currencyFrom");
        const toEl = document.getElementById("currencyTo");
        const totalPriceEl = document.getElementById("cartTotalPrice");

        async function fetchRates() {
            try {
                const res = await fetch(`https://openexchangerates.org/api/latest.json?app_id=${APP_ID}`);
                const data = await res.json();

                if (data.error) {
                    throw new Error(data.description || "API error");
                }

                rates = data.rates;
                calculate();
            } catch (err) {
                console.error("Currency API error:", err);
                if (totalPriceEl) {
                    totalPriceEl.textContent = "Error";
                }
            }
        }

        function calculate() {
            if (!rates || !fromEl || !toEl || !totalPriceEl) return;
            if (!rates[fromEl.value] || !rates[toEl.value]) return;

            const amount = parseFloat(totalPriceEl.dataset.amount || 0);
            const from = fromEl.value;
            const to = toEl.value;
            const converted = amount * (rates[to] / rates[from]);

            totalPriceEl.textContent = `${converted.toFixed(2)} ${to}`;
        }

        fromEl.addEventListener("change", calculate);
        toEl.addEventListener("change", calculate);

        fetchRates();
    </script>
</body>

</html>