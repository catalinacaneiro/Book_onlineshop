<!-- LOGIKEN MED METODER TILL CART - LÄGGA TILL, TA BORT OSV.  -->

<?php
require_once("Models/cart_item.php");

class Cart
{
    private $cartRepository;
    private $session_id;
    private $user_id;
    private $cartItems = [];

    public function __construct(
        $cartRepository,
        $session_id,
        $user_id = null
    ) {
        $this->cartRepository = $cartRepository;
        $this->session_id = $session_id;
        $this->user_id = $user_id;
        
        $this->cartItems = $this->cartRepository->getCartItems($user_id, $session_id);
    }

    public function addItem($product_id, $quantity)
    {
        $item = $this->getCartItem($product_id);

        if (!$item) {
            $item = new CartItem();

            $item->product_id = $product_id;
            $item->quantity = $quantity;

            $this->cartItems[] = $item;
        } else {
            $item->quantity += $quantity;
        }

        $this->cartRepository->updateCartItem(
            $this->user_id,
            $this->session_id,
            $product_id,
            $item->quantity
        );
    }

    public function removeItem($product_id, $quantity)
    {
        $item = $this->getCartItem($product_id);

        if (!$item) {
            return;
        }

        $item->quantity -= $quantity;

        $this->cartRepository->updateCartItem(
            $this->user_id,
            $this->session_id,
            $product_id,
            $item->quantity
        );

        if ($item->quantity <= 0) {

            $this->cartItems = array_filter(
                $this->cartItems,
                fn($cartItem)
                => $cartItem->product_id != $product_id
            );
        }
    }


// Vad denna metoden säger: "Leta efter en produkt i cart-arrayen" $this->cartItems = objekt i minnet 
    public function getCartItem($product_id)
    {
        foreach ($this->cartItems as $item) {

            if ($item->product_id == $product_id) {
                return $item;
            }
        }

        return null;
    }

    public function getItems()
    {
        return $this->cartItems;
    }

    public function getItemsCount()
    {
        $count = 0;

        foreach ($this->cartItems as $item) {

            $count += $item->quantity;
        }

        return $count;
    }

    public function getTotalPrice()
    {
        $total = 0;

        foreach ($this->cartItems as $item) {

            $total += $item->rowPrice;
        }

        return $total;
    }

    public function clearCart()
    {
        $this->cartItems = [];
    }


    public function convertSessionToUser($user_id, $newSessionId)
{
    $this->cartRepository->convertSessionToUser
    (
        $this->session_id,
        $user_id,
        $newSessionId
    );

    $this->user_id = $user_id;
    $this->session_id = $newSessionId;
}

}
?>