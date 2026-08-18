<?php
require_once("Models/cart_item.php");

class CartRepository
{
    private PDO $pdo;


    public function getProductById($product_id)
{
    $query = $this->pdo->prepare("
        SELECT id, title, stock_quantity, price
        FROM products
        WHERE id = :id
    ");

    $query->execute(['id' => $product_id]);

    return $query->fetch(PDO::FETCH_OBJ);
}

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCartItems($user_id, $session_id): array
    {
        $query = $this->pdo->prepare("SELECT ci.id, ci.cart_id, ci.product_id, ci.quantity, p.title, p.price, p.img, (p.price * ci.quantity) AS rowPrice FROM cart_items ci JOIN carts c ON c.id = ci.cart_id JOIN products p ON p.id = ci.product_id WHERE c.user_id = :user_id OR c.session_id = :session_id");
        $query->execute
        ([
                'user_id' => $user_id,
                'session_id' => $session_id
            ]);

        return $query->fetchAll(
            PDO::FETCH_CLASS,
            'CartItem'
        );
    }



    function convertSessionToUser($session_id, $user_id, $newSessionId)
    {
        $query = $this->pdo->prepare("UPDATE cart_items SET user_id=:user_id, session_id=:newSessionId WHERE session_id = :session_id");

        $query->execute
        ([
                'session_id' => $session_id,
                'user_id' => $user_id,
                'newSessionId' => $newSessionId
            ]);
    }

    public function updateCartItem($user_id, $session_id, $product_id, $quantity): void {
    // 1. Hitta cart
    $query = $this->pdo->prepare(
        "SELECT id
         FROM carts
         WHERE user_id = :user_id
            OR session_id = :session_id
         LIMIT 1"
    );

    $query->execute([
        'user_id' => $user_id,
        'session_id' => $session_id
    ]);

    $cart = $query->fetch(PDO::FETCH_ASSOC);

    // 2. Skapa cart om den inte finns
    if (!$cart) {

        $query = $this->pdo->prepare(
            "INSERT INTO carts
                (user_id, session_id)
             VALUES
                (:user_id, :session_id)"
        );

        $query->execute([
            'user_id' => $user_id,
            'session_id' => $session_id
        ]);

        $cart_id = $this->pdo->lastInsertId();

    } else {

        $cart_id = $cart['id'];
    }

    // 3. Om quantity <= 0 → delete
    if ($quantity <= 0) {

        $query = $this->pdo->prepare(
            "DELETE FROM cart_items
             WHERE cart_id = :cart_id
             AND product_id = :product_id"
        );
        
        $query->execute([
            'cart_id' => $cart_id,
            'product_id' => $product_id
        ]);

        return;
    }

    // 4. Finns produkten redan?
    $query = $this->pdo->prepare(
        "SELECT id
         FROM cart_items
         WHERE cart_id = :cart_id
         AND product_id = :product_id"
    );

    $query->execute([
        'cart_id' => $cart_id,
        'product_id' => $product_id
    ]);

    $item = $query->fetch(PDO::FETCH_ASSOC);

    // 5. Insert eller update
    if (!$item) {

        $query = $this->pdo->prepare(
            "INSERT INTO cart_items
                (cart_id, product_id, quantity)
             VALUES
                (:cart_id, :product_id, :quantity)"
        );

    } else {

        $query = $this->pdo->prepare(
            "UPDATE cart_items
             SET quantity = :quantity
             WHERE cart_id = :cart_id
             AND product_id = :product_id"
        );
    }

    $query->execute([
        'cart_id' => $cart_id,
        'product_id' => $product_id,
        'quantity' => $quantity
    ]);
}

    


}
?>