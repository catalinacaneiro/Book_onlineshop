<?php
require_once(__DIR__ . "/../vendor/autoload.php");

\Stripe\Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

$session = null;
$error = null;

if (!empty($_GET['session_id'])) {
    try {
        $session = \Stripe\Checkout\Session::retrieve([
            'id' => $_GET['session_id'],
            'expand' => ['line_items'],
        ]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $error = "Could not retrieve order details.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Order Confirmed</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php require_once("components/nav.php"); ?>

    <div class="container py-5 text-center">
        <?php if ($error): ?>
            <p class="text-danger">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php elseif ($session): ?>
            <div class="my-5">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                <h1 class="mt-4">Thank you for your order!</h1>
                <p class="lead text-muted">Your order number is: <strong>
                        <?= htmlspecialchars($session->id) ?>
                    </strong></p>
                <p class="text-muted">A confirmation has been sent to <strong>
                        <?= htmlspecialchars($session->customer_details->email ?? 'your email') ?>
                    </strong>.</p>
            </div>

            <?php if (!empty($session->line_items->data)): ?>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h4 class="mb-3">Order summary</h4>
                        <ul class="list-group mb-4">
                            <?php foreach ($session->line_items->data as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($item->description) ?>
                                    <span class="badge bg-secondary rounded-pill">x
                                        <?= $item->quantity ?>
                                    </span>
                                    <span>
                                        <?= number_format($item->amount_total / 100, 2) ?> SEK
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="fw-bold">Total:
                            <?= number_format($session->amount_total / 100, 2) ?> SEK
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <a href="/" class="btn btn-dark mt-3">Continue shopping</a>
        <?php else: ?>
            <p class="text-muted">No order information found.</p>
            <a href="/" class="btn btn-dark mt-3">Go to shop</a>
        <?php endif; ?>
    </div>

    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>