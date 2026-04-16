<?php
include_once("Models/Product.php");

class Database {
    public $pdo;
    
    function __construct(){
        $host = "localhost";
        $db   = "icecreams";
        $user = "root";
        $pass = "root";
        $port = 8889;

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    function getAllProducts(){
        $query = $this->pdo->query("SELECT id, name AS title, betyg AS price, betyg AS stockLevel, 'Glass' AS categoryName FROM top_five ORDER BY betyg DESC, name ASC");
        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $products;
    }

    function getAllCategories(){
        return ["Glass"];
    }
}
?>