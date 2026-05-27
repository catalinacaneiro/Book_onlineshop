<?php
require_once("Models/database.php");
require_once("Models/ProductRepository.php");
require_once("Models/CategoryRepository.php");

$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);

$sort = $_GET['sort'] ?? 'title';
$order = $_GET['order'] ?? 'asc';

if (!in_array($sort, ['title', 'price'], true)) {
    $sort = 'title';
}

$order = strtolower($order);
if (!in_array($order, ['asc', 'desc'], true)) {
    $order = 'asc';
}

$selectedOption = $sort . '-' . $order;
$getAllBooks = $productRepo->getAllProductsSorted($sort, $order);
$allCategories = $categoryRepo->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php require_once("components/nav.php"); ?>
    <?php require_once("components/header.php"); ?>
    <section class="pt-2 pb-0">
        <div class="container px-4 px-lg-5">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-center">
                    <form class="d-flex justify-content-center mb-3" method="get" action="/allProducts">
                        <select class="form-select w-auto" id="sortselect" aria-label="Sort all products">
                            <option value="title-asc" <?php echo $selectedOption === 'title-asc' ? 'selected' : ''; ?>>
                                Title A-Z</option>
                            <option value="title-desc" <?php echo $selectedOption === 'title-desc' ? 'selected' : ''; ?>>
                                Title Z-A</option>
                            <option value="price-asc" <?php echo $selectedOption === 'price-asc' ? 'selected' : ''; ?>>
                                Sort by price: low to high</option>
                            <option value="price-desc" <?php echo $selectedOption === 'price-desc' ? 'selected' : ''; ?>>
                                Sort by price: high to low</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
    $popularProduct = $getAllBooks;
    require_once("components/section.php");
    ?>
    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>