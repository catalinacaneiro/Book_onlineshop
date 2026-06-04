<?php
require_once("config/database.php");
require_once("repositories/ProductRepository.php");
require_once("repositories/CategoryRepository.php");
require_once("repositories/cartRepository.php");
require_once("Models/cart.php");


$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$allProducts = $productRepo->getAllProducts();
$allCategories = $categoryRepo->getAllCategories();

if (!isset($antalICarten)) {
    $cartRepository = new CartRepository($db->pdo);
    $cart = new Cart($cartRepository, session_id());
    $antalICarten = $cart->getItemsCount();
}

?>

<style>
    .search-input::placeholder {
        color: rgba(108, 117, 125, 0.45);
    }
</style>



<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container px-4 px-lg-5">
        <div class="w-100">
            <div class="d-flex align-items-center mb-3">
                <a class="navbar-brand fs-1" href="/index.php">Quills</a>
                <!-- SÖKNING - form  -->
                <form method="get" action="/search" class="d-flex ms-auto me-3">
                    <div class="input-group">
                        <input name="q" class="form-control rounded-0 search-input" type="search"
                            placeholder="Type here to search" aria-label="Search for..." />
                        <button type="submit" class="btn btn-outline-secondary rounded-0"
                            id="button-search">Search</button>
                    </div>
                </form>
                <!-- VARUKORG - form -->
                <form class="d-flex">
                    <button class="btn btn-outline-dark rounded-0" type="submit">
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"
                            id="cartItemCount"><?php echo $antalICarten; ?></span>
                    </button>
                </form>
            </div>

            <ul class="navbar-nav fs-6 flex-row gap-2 align-items-center">
                <!-- DROPDOWN - Categories -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Categories</a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- Länk till allProducts.page.php - För att det ska funka ska man skapa en rout i index.php -->
                        <li><a class="dropdown-item" href="/allProducts">All Products</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <!-- Länk till category sida -->
                        <?php
                        foreach ($allCategories as $category) {
                            ?>
                            <li><a class="dropdown-item" href="/category?id=<?php echo $category->id; ?>">
                                    <?php echo $category->category_name; ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#!">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Create account</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
            </ul>
        </div>
    </div>
</nav>