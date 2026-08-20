<?php
ob_start(); // startar output buffering. 

session_start(); // återupptar en existenserande session. 

require_once("config/database.php");
require_once("utils/router.php");

$database = new Database();

$router = new Router();
$router->addRoute('/', function () {
    require_once(__DIR__ . '/pages/start.page.php');
});
$router->addRoute('/index.php', function () {
    require_once(__DIR__ . '/pages/start.page.php');
});
$router->addRoute('/product', function () {
    require_once(__DIR__ . '/pages/product.page.php');
});
$router->addRoute('/category', function () {
    require_once(__DIR__ . '/pages/category.page.php');
});
$router->addRoute('/admin', function () {
    require_once(__DIR__ . '/pages/admin.php');
});
$router->addRoute('/admin/new', function () {
    require_once(__DIR__ . '/pages/newProduct.php');
});
$router->addRoute('/admin/edit', function () {
    require_once(__DIR__ . '/pages/edit.php');
});
$router->addRoute('/search', function () {
    require_once(__DIR__ . '/pages/search.page.php');
});
$router->addRoute('/allProducts', function () {
    require_once(__DIR__ . '/pages/allProducts.page.php');
});
$router->addRoute('/about', function () {
    require_once(__DIR__ . '/pages/about.page.php');
});
$router->addRoute('/addToCart', function () {
    require_once(__DIR__ . '/pages/addToCart.php');
});
$router->addRoute('/removeFromCart', function () {
    require_once(__DIR__ . '/pages/removeFromCart.php');
});
$router->addRoute('/viewCart', function () {
    require_once(__DIR__ . '/pages/viewCart.php');
});
$router->addRoute('/checkout', function () {
    require_once(__DIR__ . '/pages/checkout.php');
});
$router->addRoute('/checkoutSuccess', function () {
    require_once(__DIR__ . '/pages/checkoutSuccess.php');
});
$router->addRoute('/javascriptAddToCart', function () {
    require_once(__DIR__ . '/api/addToCart.php');
});
$router->addRoute('/javascriptRemoveFromCart', function () {
    require_once(__DIR__ . '/api/removeFromCart.php');
});
$router->addRoute('/javascriptFetchCart', function () {
    require_once(__DIR__ . '/api/fetchCart.php');
});
$router->addRoute('/readfreightrules', function () {
    require_once(__DIR__ . '/integrations/readfreightrules.php');
});
$router->addRoute('/prisjakt.xml', function () {
    require_once(__DIR__ . '/api/prisjakt.php');
});
$router->addRoute('/createAccount', function () {
    require_once(__DIR__ . '/pages/createAccount.php');
});
$router->addRoute('/login', function () {
    require_once(__DIR__ . '/pages/login.php');
});
$router->addRoute('/logout', function () {
    require_once(__DIR__ . '/pages/logout.php');
});



$router->dispatch();
