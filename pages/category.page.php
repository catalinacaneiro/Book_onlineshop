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
// select * from category where id=$categoryid
$products = $productRepo->getProductsForCategory($categoryid);
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
    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

    
</body>
</html>

<h1>Products in this category</h1>

<?php foreach ($products as $product) { ?>  
<div>  
    <h2><?php echo $product->title; ?></h2>  
    <p><?php echo $product->description; ?></p>  
    <p><?php echo $product->price; ?> kr</p>  
</div>  
<?php } ?>


