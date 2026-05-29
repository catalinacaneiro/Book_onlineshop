<?php
require_once("Models/Product.php");

class ProductRepository
{
    private PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    function getAllProducts(): array
    {
        $query = $this->pdo->query(
            "SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, p.img, c.category_name FROM products p LEFT JOIN category c ON c.id = p.category_id ORDER BY p.price DESC"
        );

        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $products;
    }

    function getAllProductsSorted($sort, $order): array
    {
        if (!in_array($sort, ['id', 'title', 'price', 'stock_quantity'], true)) {
            $sort = 'title';
        }

        $order = strtolower($order);
        if (!in_array($order, ['asc', 'desc'], true)) {
            $order = 'asc';
        }

        $query = $this->pdo->query(
            "SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, p.img, c.category_name
             FROM products p
             LEFT JOIN category c ON c.id = p.category_id
             ORDER BY p.$sort $order"
        );

        return $query->fetchAll(PDO::FETCH_CLASS, "Product");
    }


    function getProduct($id): Product
    {
        $prep = $this->pdo->prepare("SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, p.img, c.category_name FROM products p LEFT JOIN category c ON c.id = p.category_id WHERE p.id = :id LIMIT 1"); //kolla upp LIMIT

        $prep->setFetchMode(PDO::FETCH_CLASS, "Product");
        $prep->execute(["id" => $id]);
        return $prep->fetch();
    }


    function getProductByTitle($title): ?Product
    {
        $prep = $this->pdo->prepare('SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, p.img, c.category_name FROM products p LEFT JOIN category c ON c.id = p.category_id  WHERE p.title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function addProduct($title, $price, $stock_quantity, $category_id)
    {
        $prep = $this->pdo->prepare("INSERT INTO products (title, price, stock_quantity, category_id) VALUES (:title, :price, :stock_quantity, :category_id)");

        $prep->execute([
            "title" => $title,
            "price" => $price,
            "stock_quantity" => $stock_quantity,
            "category_id" => $category_id
        ]);

        return $this->pdo->lastInsertId();

    }


    function getProductsForCategory($category_id, $sort, $order): array
    {
        /* if sats för att skydda mot SQL injection  */

        if (!in_array($sort, ['title', 'price'], true)) {
            $sort = 'title';
        }

        $order = strtolower($order);
        if (!in_array($order, ['asc', 'desc'], true)) {
            $order = 'asc';
        }

        $query = $this->pdo->prepare(
            "SELECT id, category_id, description, title, price, stock_quantity, img 
            FROM products 
            WHERE category_id = :category_id ORDER BY $sort $order"
        );

        $query->execute(['category_id' => $category_id]);

        return $query->fetchAll(PDO::FETCH_CLASS, "Product");


    }

    function searchBooks($q): array
    {
        $prep = $this->pdo->prepare(
            "SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, p.img, c.category_name
             FROM products p
             LEFT JOIN category c ON c.id = p.category_id
             WHERE p.title LIKE :q OR p.description LIKE :q OR c.category_name LIKE :q
             ORDER BY p.title ASC"
        );

        $prep->execute(['q' => '%' . $q . '%']);
        return $prep->fetchAll(PDO::FETCH_CLASS, "Product");
    }


    function getPopularProducts(): array
    {
        $query = $this->pdo->query("SELECT * FROM products ORDER BY popularity_product DESC LIMIT 0,10"); // Products är TABELL 
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
    }



    function saveProduct($product)
    {
        $query = $this->pdo->prepare("UPDATE products SET title=:title, description=:description, price=:price, stock_quantity=:stock_quantity WHERE id=:id");
        $query->execute([
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity,
            'id' => $product->id
        ]);
    }



}
?>