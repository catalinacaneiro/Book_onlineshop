<?php
ob_start(); // startar output buffering. 

session_start(); // återupptar en existenserande session. 

require_once("Models/database.php");
require_once("utils/router.php");

$database = new Database();

$router = new Router();
$router->addRoute('/', function () {
    require_once( __DIR__ . '/pages/start.page.php');
});
$router->addRoute('/index.php', function () {
    require_once( __DIR__ . '/pages/start.page.php');
});
$router->addRoute('/product', function () {
    require_once( __DIR__ . '/pages/product.page.php');
});
$router->addRoute('/category', function () {
    require_once( __DIR__ . '/pages/category.page.php');
});
$router->addRoute('/admin', function () {
    require_once( __DIR__ . '/pages/admin.php');
});
$router->addRoute('/search', function () {
    require_once( __DIR__ . '/pages/search.page.php');
});
$router->addRoute('/allProducts', function () {
    require_once( __DIR__ . '/pages/allProducts.page.php');
});
$router->addRoute('/edit', function () {
    require_once( __DIR__ . '/pages/edit.php');
});
$router->addRoute('/about', function () {
    require_once( __DIR__ . '/pages/about.page.php');
});
$router->addRoute('/addToCart', function () {
    require_once( __DIR__ . '/pages/addToCart.php');
});
$router->dispatch();
