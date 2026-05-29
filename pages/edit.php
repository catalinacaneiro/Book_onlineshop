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

    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('stock_quantity')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);

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

                        <form method="POST" class="card p-4 shadow-sm">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text"
                                    class="form-control <?php echo $v->get_error_message('title') ? 'is-invalid' : ''; ?>"
                                    id="title" name="title" value="<?php echo htmlspecialchars($product->title); ?>">
                                <span class="invalid-feedback d-block"><?php echo $v->get_error_message('title'); ?></span>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    rows="4"><?php echo htmlspecialchars($product->description); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01"
                                    class="form-control <?php echo $v->get_error_message('price') ? 'is-invalid' : ''; ?>"
                                    id="price" name="price" value="<?php echo htmlspecialchars($product->price); ?>">
                                <span class="invalid-feedback d-block"><?php echo $v->get_error_message('price'); ?></span>
                            </div>

                            <div class="mb-4">
                                <label for="stock_quantity" class="form-label">Stock Level</label>
                                <input type="number"
                                    class="form-control <?php echo $v->get_error_message('stock_quantity') ? 'is-invalid' : ''; ?>"
                                    id="stock_quantity" name="stock_quantity"
                                    value="<?php echo htmlspecialchars($product->stock_quantity); ?>">
                                <span
                                    class="invalid-feedback d-block"><?php echo $v->get_error_message('stock_quantity'); ?></span>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="/admin" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
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