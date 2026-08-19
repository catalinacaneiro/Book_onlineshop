<?php

require_once("repositories/ProductRepository.php");
require_once("repositories/CategoryRepository.php");
require_once("repositories/userRepository.php");



$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$popularProduct = $productRepo->getPopularProducts();
$allCategories = $categoryRepo->getAllCategories();

$userRepo = new UserRepository($db->pdo);

$userRepo ->logoutUser();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Logout</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php require_once("components/nav.php"); ?>
    <?php require_once("components/header.php"); ?>
    <section class="logout-section">
        <div class="logout-wrapper">
            <h1 class="logout-message">You have been logged out</h1>
        </div>
    </section>
    
    <?php require_once("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>