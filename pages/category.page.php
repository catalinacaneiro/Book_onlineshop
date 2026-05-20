<?php
require_once("Models/database.php");
require_once("Models/ProductRepository.php");
require_once("Models/CategoryRepository.php");




$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$allCategories = $categoryRepo->getAllCategories();




//$categoryid kommer ju från URL  category.php?id=1
$categoryid = $_GET['id'];
$sort = $_GET['sort'] ?? 'title';
$order = $_GET['order'] ?? 'asc';
$selectedOption = $sort . '-' . $order;
// select * from category where id=$categoryid
$products = $productRepo->getProductsForCategory($categoryid, $sort, $order);
// select * from products where category_id=$categoryId
$allCategories = $categoryRepo->getAllCategories();

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




    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row mb-4">
                <div class="col-12 col-md-8 mx-auto">
                    <h1 class="text-center mb-3">Products in this category</h1>

                    <!-- form för soretering  -->
                    <form class="d-flex justify-content-center mb-3" method="get" action="/category">
                        <input type="hidden" name="id" value="<?php echo $categoryid; ?>">
                        <select class="form-select w-auto" name="sortorder" id="sortselect"
                            onchange="this.form.submit()">
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
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($products as $product) { ?>
                    <div class="col mb-5 book-column">
                        <div class="card h-100 book-card">
                            <?php
                            $imagePath = ""; 
                            $getImg = trim((string) ($product->img ?? ''));
                            if ($getImg !== '') {
                                $imagePath = $getImg;
                            }
                            ?>
                            <img class="card-img-top book-img" 
                            src="<?php echo htmlspecialchars($imagePath) ?>"
                            alt="<?php echo htmlspecialchars($product->title); ?>" />


                            <div class="card-body book-body">
                                <div class="text-center">
                                    <a class="text-dark text-decoration-none" href="/product?id=<?php echo $product->id ?>">
                                        <h5 class="rubrik"><?php echo htmlspecialchars($product->title); ?></h5>
                                        <?php echo htmlspecialchars($product->description); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer book-footer">
                                <div class="text-center"><a class="book-btn"
                                        href="/product?id=<?php echo (int) $product->id; ?>">Product Details</a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>

</html>