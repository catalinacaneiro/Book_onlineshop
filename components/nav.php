<?php
require_once("Models/database.php");
require_once("Models/ProductRepository.php");
require_once("Models/CategoryRepository.php");


$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$allProducts = $productRepo->getAllProducts();
$allCategories = $categoryRepo->getAllCategories();

?>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="/index.php">The Quill Bookshop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <!-- DROPDOWN - Categories -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <?php 
                                foreach($allCategories as $category){
                                    ?>
                                    <li><a class="dropdown-item" 
                                        href="/category?id=<?php echo $category->id; ?>">
                                        <?php echo $category->category_name;?>
                                        </a>
                                    </li>
                                <?php 
                                }
                                ?>
           
                            </ul> 
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#!">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Create account</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    </ul>

                    <!-- SÖKNING - form  -->
                     <form method="get" action="/search">
                        <div class="input-group">
                            <input name="q" class="form-control" type="search" placeholder="Search for..." aria-label="Search for..." />
                            <button type="submit" class="btn btn-outline-secondary" id="button-search" type="button">Go!</button>
                        </div>
                    </form>
        

                    <!-- VARUKORG - form -->
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
</nav>