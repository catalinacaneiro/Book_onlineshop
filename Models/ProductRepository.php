<?php 
require_once ("Models/Product.php");



class ProductRepository {
    private PDO $pdo; 

    function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }


 function getAllProducts(){
    $query = $this->pdo->query("SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, c.category_name FROM products p LEFT JOIN category c ON c.id = p.category_id ORDER BY p.price DESC"
    );
    
    $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");
    return $products;
    }


    function getProduct($id){
        $prep = $this->pdo->prepare("SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, c.category_name FROM products p LEFT JOIN category c ON c.id = p.category_id WHERE p.id = :id LIMIT 1"); //kolla upp LIMIT

        $prep->setFetchMode(PDO::FETCH_CLASS, "Product");
        $prep->execute(["id" => $id]);
        return $prep->fetch();
        }
    

    function getProductByTitle($title){
        $prep = $this->pdo->prepare('SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, c.category_name FROM products p LEFT JOIN category c ON c.id = p.category_id  WHERE p.title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS,'Product');
        $prep->execute(['title'=> $title]); 
        return  $prep->fetch();
    }

    function addProduct($title,$price,$stock_quantity, $category_id){
        $prep = $this->pdo->prepare("INSERT INTO products (title, price, stock_quantity, category_id) VALUES (:title, :price, :stock_quantity, :category_id)");
      
        $prep->execute([
            "title" => $title,
            "price" => $price,
            "stock_quantity" => $stock_quantity,
            "category_id" => $category_id
        ]);

        return $this->pdo->lastInsertId();
                   
    }


     function getProductsForCategory($category_id){
        $query = $this->pdo->prepare(
            "SELECT id, category_id, description, title, price, stock_quantity 
            FROM products 
            WHERE category_id = :category_id");

        $query->execute(['category_id' => $category_id]);

        return $query->fetchAll(PDO::FETCH_CLASS, "Product");

        
    }

    function searchBooks($q){
        $prep = $this->pdo->prepare(
            "SELECT p.id, p.title, p.stock_quantity, p.price, p.category_id, p.popularity_product, p.description, c.category_name
             FROM products p
             LEFT JOIN category c ON c.id = p.category_id
             WHERE p.title LIKE :q OR p.description LIKE :q OR c.category_name LIKE :q
             ORDER BY p.title ASC"
        );

        $prep->execute(['q' => '%' . $q . '%']);
        return $prep->fetchAll(PDO::FETCH_CLASS, "Product");
    }


      function getPopularProducts(){
            $query = $this->pdo->query("SELECT * FROM products ORDER BY popularity_product DESC LIMIT 0,10"); // Products är TABELL 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
        }
}
?>