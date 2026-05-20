<h1>Edit product</h1>
<?php
require_once("Models/database.php");
require_once("Models/ProductRepository.php");
require_once("Models/CategoryRepository.php");
require_once("utils/validaring.php");

$id = $_GET['id'];

$db = new Database();
$productRepo = new ProductRepository($db->pdo);
$categoryRepo = new CategoryRepository($db->pdo);
$product = $productRepo->getProduct($id);
$v = new Validator($_POST);
$allCategories = $categoryRepo->getAllCategories();


if ($_SERVER['REQUEST_METHOD'] == 'POST') { // HAR MAN SUBMITTAT FORM?

    $product->title = $_POST['title'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->stock_quantity = $_POST['stock_quantity'];

    // 3 regler
    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('stock_quantity')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);
    // 4 validera!
    if ($v->is_valid()) {
        $productRepo->saveProduct($product);
        header("Location: /admin"); // Hoppa till denna sida = redirect
        exit; // KLAR KÖR INTE MER I DENNA FIL
    }
    // SPARA
    // ta data från form och spara i databasen
}

echo "Du klickade på Product id: " . $id;

// Hämta en Product från databasen med id = $id
// SELECT * from product where id = $id

?>
<h1>Edit Product</h1>

<h1><?php echo $product->title; ?></h1>
<form method="POST">
    <div>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo $product->title; ?>">
        <span class="invalid-feedback"><?php echo $v->get_error_message('title'); ?></span>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description"><?php echo $product->description; ?></textarea>
    </div>
    <div>
        <label for="price">Price</label>
        <input type="number" id="price" name="price" value="<?php echo $product->price; ?>">
        <span class="invalid-feedback"><?php echo $v->get_error_message('price'); ?></span>
    </div>
    <div>
        <label for="stock_quantity">Stock Level</label>
        <input type="text" id="stock_quantity" name="stock_quantity" value="<?php echo $product->stock_quantity; ?>">
        <span class="invalid-feedback"><?php echo $v->get_error_message('stock_quantity'); ?></span>
    </div>
    <div>
        <button type="submit">Save</button>
    </div>
</form>

