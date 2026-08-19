<?php
require_once("repositories/ProductRepository.php");
require_once("repositories/CategoryRepository.php");
require_once("utils/validaring.php");


$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$allCategories = $categoryRepo->getAllCategories();
$v = new Validator($_POST);
$product = null; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('stock_quantity')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);
    $v->field('category_id')->required()->numeric()->min_val(1);

    if ($v->is_valid()) {
        $productRepo->addProduct(
            $_POST['title'],
            $_POST['price'],
            $_POST['stock_quantity'],
            $_POST['category_id'],
            $_POST['description'] ?? ''
        );
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
    <title>New Product</title>
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
            <h1>New Product</h1>
            <form method="POST" class="card p-4 shadow-sm">
               
                <?php
                $product = null;
                $formAction = "";
                $buttonText = "Create Product";


                require("components/productForm.php");
                ?>

            </form>