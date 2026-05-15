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

    <h1>Products in this category</h1>

    <form method="get" action="/category">
        <input type="hidden" name="id" value="<?php echo $categoryid; ?>">
        <select id="sortselect">
            <option value="title-asc" <?php echo $selectedOption === 'title-asc' ? 'selected' : ''; ?>>Title A-Z</option>
            <option value="title-desc" <?php echo $selectedOption === 'title-desc' ? 'selected' : ''; ?>>Title Z-A</option>
            <option value="price-asc" <?php echo $selectedOption === 'price-asc' ? 'selected' : ''; ?>>Sort by price: low to high</option>
            <option value="price-desc" <?php echo $selectedOption === 'price-desc' ? 'selected' : ''; ?>>Sort by price: high to low</option>
        </select>
    </form>

    <?php foreach ($products as $product) { ?>
    <div>
        <h2>
            <a href="/product?id=<?php echo (int)$product->id; ?>"><?php echo htmlspecialchars($product->title); ?></a>
        </h2>
        <p><?php echo $product->description; ?></p>
        <p><?php echo $product->price; ?> kr</p>
    </div>
    <?php } ?>

    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>
</html>
    
    


