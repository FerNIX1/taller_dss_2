<?php


class cart
{
    function __construct(){}

   
    public function get()
    {
        if  (isset($_SESSION['cart']))
        {
           
            $ids = $this->get_ids();

         
            global $Products;
            return $Products->get($ids);
        }
        return NULL;
    }

   
    public function get_ids()
    {
        if (isset($_SESSION['cart']))
        {
            return array_keys($_SESSION['cart']);
        }
        return NULL;
    }
    // ========================================================================
    // sum
    public function get_total_price()
    {
        $products = $this->get(); // get all products in cart
        $total_price = 0;

        if (!empty($products)) {
            foreach ($products as $product) {
                $total_price += $product['price'];
            }
        }

        return $total_price;
    }
    // ========================================================================
        public function remove($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // ========================================================================
   
    public function add($id, $num = 1)
    {
       
        $cart = array();
        if (isset($_SESSION['cart']))
        {
            $cart = $_SESSION['cart'];
        }

      
        if (isset($cart[$id]))
        {
         
            $cart[$id] = $cart[$id] + $num;
        }
        else
        {
        
            $cart[$id] = $num;
        }
        $_SESSION['cart'] = $cart;
    }
    
  
    public function empty_cart()
    {
        unset($_SESSION['cart']);
    }

   
    public function create_cart()
    {
    
    $products = $this->get();
    $total_price = $this->get_total_price();

    if (!empty($products)) {
        echo "<table style='border-collapse: collapse; margin: 0 auto;>";
        echo "<thead style='border: 1px solid black;'><tr><th style='border: 1px solid black;'>Product Name</th><th style='border: 1px solid black;'>description</th><th style='border: 1px solid black;'>Price</th></tr></thead>";
        echo "<tbody style='border: 1px solid black;'>";
        foreach ($products as $product) {
            echo "<tr style='border: 1px solid black;'>";
            echo "<td style='border: 1px solid black;'>" . $product['name'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $product['description'] . "</td>";
            echo "<td style='border: 1px solid black;'>$" . $product['price'] . "</td>";
            echo "</tr>";
        }
        echo "<tr><td style='border: 1px solid black;'>Total Price:</td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'>$" . $total_price . "</td></tr>";
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "Your cart is empty.";
    }
    }
}