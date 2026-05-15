<h1>Edit product</h1>
    <?php
    require_once ("Models/database.php");
    require_once("Models/ProductRepository.php");
    require_once("Models/CategoryRepository.php");
    
    $id = $_GET['id'] ?? null;

    $db = new Database();
    $productRepo = new ProductRepository($db->pdo);
    $categoryRepo = new CategoryRepository($db->pdo);
    $product = $productRepo->getProduct($id);
    $allCategories = $categoryRepo->getAllCategories();



    
    
     ?>