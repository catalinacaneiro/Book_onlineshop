<?php

class Cart
{
    private $dbContext;
    private $session_id;
    private $user_id;
    private $cart_items = [];


    public function __construct($dbContext, $session_id, $user_id = null)
    {
        $this->dbContext = $dbContext;
        $this->session_id = $session_id;
        $this->user_id = $user_id;
        // i princip = select * from cartitem where sessionId = $session_id 
        // 
        $this->cart_items = $this->dbContext->getCartItems($user_id, $session_id);

    }


    public function convertSessionToUser($user_id, $newSessionId)
    {
        $this->dbContext->convertSessionToUser($this->session_id, $user_id, $newSessionId);

        $this->user_id = $user_id;
        $this->session_id = $newSessionId;
    }

    public function addItem($product_id, $quantity)
    {
        $item = $this->getCartItem($product_id);
        if (!$item) {
            $item = new CartItem();
            $item->product_id = $product_id;
            $item->quantity = $quantity;
            array_push($this->cartItems, $item);
        } else {
            $item->quantity += $quantity;
        }
        $this->dbContext->updateCartItem($this->user_id, $this->session_id, $product_id, $item->quantity);
    }

    public function removeItem($productId, $quantity)
    {
        $item = $this->getCartItem($productId);
        if (!$item) {
            return;
        }
        $item->quantity -= $quantity;
        $this->dbContext->updateCartItem($this->userId, $this->session_id, $productId, $item->quantity);
        if ($item->quantity <= 0) {
            array_splice($this->cartItems, array_search($item, $this->cartItems), 1);
        }
    }

    public function getCartItem($productId)
    {
        foreach ($this->cartItems as $item) {
            if ($item->productId == $productId) {
                return $item;
            }
        }
        return null;
    }


    public function getItemsCount()
    {
        $count = 0;
        foreach ($this->cartItems as $item) {
            $count += $item->quantity;
        }
        return $count;
        //return count($this->cartItems);
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->cartItems as $item) {
            $total += $item->rowPrice;
        }
        return $total;
    }


    public function getItems()
    {
        return $this->cartItems;
    }

    public function clearCart()
    {
        $this->cartItems = [];
    }


}
?>