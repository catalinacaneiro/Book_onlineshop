<?php
require_once("Models/database.php");
require_once("Models/ProductRepository.php");
require_once("Models/CategoryRepository.php");


$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$listAllProducts = $productRepo->getAllProducts();



foreach ($listAllProducts as $product) {
    ?>

    <!-- XML KOD -->

    <h1><?php echo htmlspecialchars($product->price); ?></h1>

    <!-- EXEMPEL:
     <item>

      <g:link>http://localhost:8000/link</g:link>. => om man skulle vara live i clouden så skulle det vara en link till en riktigt webbshopp typ http://quills.com/link//g......
     
    </item>  
    -->



    <!-- avslutar php loop -->
<?php } ?>