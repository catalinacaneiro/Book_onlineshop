<?php
require_once("Models/database.php");
require_once("Models/ProductRepository.php");
require_once("Models/CategoryRepository.php");

$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$allCategories = $categoryRepo->getAllCategories();

$productId = $_GET['id'] ?? null;
$product = null;

if ($productId) {
    $product = $productRepo->getProduct($productId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width='device-width', initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php require_once("components/nav.php"); ?>

    <?php if ($product) { ?>

        <section class="product-layout">
            <div class="product-category">
                <h2><?php echo htmlspecialchars($product->category_name); ?></h2>
            </div>
            <?php
            $getImg = trim((string) ($product->img ?? ''));
            if ($getImg !== '') {
                $imagePath = $getImg;
            }
            ?>
            <div class="product-media">
                <img class="product-cover"
                src="<?php echo htmlspecialchars($imagePath) ?>" alt="<?php echo htmlspecialchars($product->title); ?>">
            </div>

        
            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($product->title); ?></h1>
                <p>In stock: <?php echo $product->stock_quantity; ?></p>
                <p class="product-price">$<?php echo $product->price; ?></p>
                
                <p class="product-description"><?php echo htmlspecialchars($product->description); ?></p>
                <div class="product-actions">
                    <button class="btn btn-outline-dark" type="button">Add to cart</button>
                    <a class="category-back" href="/category?id=<?php echo $product->category_id; ?>">Back to category</a>
                </div>

                <?php } else { ?>
                    <h1>Product not found</h1>
                    <p>No product selected or this product does not exist.</p>
                    <p><a href="/allProducts">View all products</a></p>
                <?php } ?>
            </div>
    </section>

    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>

</html>