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

    $sortorder = $_GET['sortorder'] ?? 'title-asc';
    [$sort, $order] = array_pad(explode('-', $sortorder, 2), 2, null);
    $sort = $sort ?? 'title';
    $order = $order ?? 'asc';

    $allowedSort = ['id', 'title', 'price', 'stock_quantity'];
    if (!in_array($sort, $allowedSort, true)) {
        $sort = 'title';
    }
    if (!in_array($order, ['asc', 'desc'], true)) {
        $order = 'asc';
    }

    $selectedOption = $sort . '-' . $order;
    $adminProducts = $productRepo->getAllProductsSorted($sort, $order);
    ?>


    <!-- Navigation-->
    <nav>
        <?php require_once("components/nav.php") ?>
    </nav>



    <!-- Section-->

    <section>


        <div class="container px-4 px-lg-5 mt-5">
            <div class="row mb-4">
                <div class="col-12 col-md-8 mx-auto">
                    <h1 class="text-center mb-3">All products</h1>

                    <!-- form för soretering  -->
                    <form class="d-flex justify-content-center mb-3" method="get" action="/admin">
                        <select class="form-select w-auto" name="sortorder" id="admin-sortselect"
                            onchange="this.form.submit()">
                            <option value="title-asc" <?php echo $selectedOption === 'title-asc' ? 'selected' : ''; ?>>
                                Title A-Z</option>
                            <option value="title-desc" <?php echo $selectedOption === 'title-desc' ? 'selected' : ''; ?>>
                                Title Z-A</option>
                            <option value="price-asc" <?php echo $selectedOption === 'price-asc' ? 'selected' : ''; ?>>
                                Sort by price: low to high</option>
                            <option value="price-desc" <?php echo $selectedOption === 'price-desc' ? 'selected' : ''; ?>>
                                Sort by price: high to low</option>
                            <option value="stock_quantity-asc" <?php echo $selectedOption === 'stock_quantity-asc' ? 'selected' : ''; ?>>
                                Sort by stock: low to high</option>
                            <option value="stock_quantity-desc" <?php echo $selectedOption === 'stock_quantity-desc' ? 'selected' : ''; ?>>
                                Sort by stock: high to low</option>
                            <option value="id-asc" <?php echo $selectedOption === 'id-asc' ? 'selected' : ''; ?>>
                                Sort by id: low to high</option>
                            <option value="id-desc" <?php echo $selectedOption === 'id-desc' ? 'selected' : ''; ?>>
                                Sort by id: high to low</option>
                        </select>
                    </form>
                </div>
            </div>



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
                    <?php foreach ($adminProducts as $product) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars(($product->id)); ?></td>
                            <td><?php echo htmlspecialchars(($product->title)); ?></td>
                            <td><?php echo htmlspecialchars(($product->category_name)); ?></td>
                            <td><?php echo htmlspecialchars(($product->price)); ?></td>
                            <td><?php echo htmlspecialchars(($product->stock_quantity)); ?></td>
                            <td>
                                <a href="/edit?id=<?php echo $product->id; ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </section>


    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Caneiro</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>