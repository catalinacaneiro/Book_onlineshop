<?php
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
$router->dispatch();
