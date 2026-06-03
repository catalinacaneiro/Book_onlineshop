<?php
require_once("config/database.php");
require_once("repositories/ProductRepository.php");
require_once("repositories/CategoryRepository.php");
require_once("utils/validaring.php");

$id = $_GET['id'] ?? null;

$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$product = $id ? $productRepo->getProduct($id) : null;
$v = new Validator($_POST);
$allCategories = $categoryRepo->getAllCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $product) {
    $product->title = $_POST['title'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->stock_quantity = $_POST['stock_quantity'];
    $product->category_id = $_POST['category_id'] ?? null;

    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('stock_quantity')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);
    $v->field('category_id')->required()->numeric()->min_val(1);

    if ($v->is_valid()) {
        $productRepo->saveProduct($product);
        header("Location: /admin");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Product</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <?php require_once("components/nav.php"); ?>
    </nav>

    <section>
        <div class="container px-4 px-lg-5 mt-5">
            <?php if (!$product) { ?>
                <div class="col-12 col-md-8 mx-auto">
                    <h1 class="text-center mb-3">Product not found</h1>
                    <p class="text-center"><a href="/admin" class="btn btn-primary">Back to admin</a></p>
                </div>
            <?php } else { ?>
                <div class="row mb-4">
                    <div class="col-12 col-md-8 mx-auto">
                        <h1 class="text-center mb-3">Edit Product</h1>
                        <p class="text-center mb-4"><?php echo htmlspecialchars($product->title); ?></p>

                        <?php
                        $formAction = "";
                        $buttonText = "Save";

                        require("components/productForm.php");
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Caneiro</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>

</html>