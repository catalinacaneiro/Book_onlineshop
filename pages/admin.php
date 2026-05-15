
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
    </head>

    <body>

        <?php
        require_once("Models/database.php");
        require_once("Models/ProductRepository.php");



        $db = new Database();
        $productRepo = new ProductRepository($db->pdo);

        $sort = $_GET['sort'] ?? 'title';
        $order = $_GET['order'] ?? 'asc'; 
        
        $allProducts = $productRepo->getAllProductsSorted($sort, $order);
        ?>


        <!-- Navigation-->

        <!-- MÅSTE ÄNDRA  -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="/index.php">SuperShoppen</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategorier</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="#!">En cat</a></li>
                            </ul> 
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#!">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Create account</a></li>
                    </ul>
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
        <!-- Header-->
        <header class="bg-dark py-5">
            <?php require_once("components/header.php")?>
        </header>


        <!-- Section-->
         <div>
            <h1>ADMIN</h1>

            <form method="get" action="/admin">
                <select name="sort" id="">
                    <option value="title" <?php echo $sort === 'title' ? 'selected' : ''; ?>>Title</option>
                    <option value="price" <?php echo $sort === 'price' ? 'selected' : ''; ?>>Price</option>
                    <option value="stock_quantity" <?php echo $sort === 'stock_quantity' ? 'selected' : ''; ?>>Stock</option>
                </select>

                <select name="order" id="">
                    <option value="asc" <?php echo $order === 'asc' ? 'selected' : ''; ?>>ASC</option>
                    <option value="desc" <?php echo $order === 'desc' ? 'selected' : ''; ?>>DESC</option>
                </select>
                
                <button type="submit">Sort</button>
            </form>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProducts as $product) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars(($product->id));?></td>
                            <td><?php echo htmlspecialchars(($product->title));?></td>
                            <td><?php echo htmlspecialchars(($product->category_name));?></td>
                            <td><?php echo htmlspecialchars(($product->price));?></td>
                            <td><?php echo htmlspecialchars(($product->stock_quantity));?></td>
                            <td>
                                <a href="/edit?id=<?php echo $product->id; ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
         </div>
        
        <!-- Footer-->
        <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Caneiro</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
