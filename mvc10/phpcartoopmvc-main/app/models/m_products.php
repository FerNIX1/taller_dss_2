<?php



class Products
{
    private $Database;
    private $db_table = 'products';

    function __construct()
    {
        global $Database;
        $this->Database = $Database;
    }


    public function get($id = NULL)
    {
        $data = array();

        if (is_array($id))
        {
            
            $items = '';
            foreach ($id as $item)
            {
                if ($items != '') 
                { 
                    $items .= ',';
                }
                $items .= $item;
            }

            if ($result = $this->Database->query("SELECT id, name, description, price, image FROM $this->db_table WHERE id IN ($items) ORDER BY name"))
            {
                if ($result->num_rows>0)
                {
                    while ($row = $result->fetch_array())
                    {
                        $data[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'description' => $row['description'],
                            'price' => $row['price'],
                            'image' => $row['image']
                        );
                    }
                }
            }

            
        }
        else if ($id != NULL)
        {

            if ($stmt = $this->Database->prepare("SELECT 
            $this->db_table.id,
            $this->db_table.name,
            $this->db_table.description,
            $this->db_table.price,
            $this->db_table.image,
            categories.name AS categories_name
            FROM $this->db_table, categories
            WHERE $this->db_table.id = ? AND $this->db_table.category_id = categories.id"))
            {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($prod_id, $prod_name, $prod_description, $prod_price, $prod_image, $cat_name);
                $stmt->fetch();

                if ($stmt->num_rows > 0)
                {
                    $data = array('id' => $prod_id, 'name' => $prod_name, 'description' => $prod_description, 'price' => $prod_price, 'image' => $prod_image, 'category_name' => $cat_name);
                }
                $stmt->close();
            }
        }
        else
        {

            if ($result = $this->Database->query("SELECT * FROM " . $this->db_table . " ORDER BY name"))
            {
                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_array())
                    {
                        $data[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'image' => $row['image']
                        );
                    }
                }
            }
        }
        return $data;
    }

  
    public function get_in_category($id)
    {
        $data = array();
        if ($stmt = $this->Database->prepare("SELECT id, name, price, image FROM " . $this->db_table . " WHERE category_id = ? ORDER BY name"))
        {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($prod_id, $prod_name, $prod_price, $prod_image);
            while ($stmt->fetch())
            {
                $data[] = array(
                    'id' => $prod_id, 
                    'name' => $prod_name,
                    'price' => $prod_price,
                    'image' => $prod_image);
            }
            $stmt->close();
        }
        return $data;
    }
   
    public function product_exists($id)
    {
        if ($stmt = $this->Database->prepare("SELECT id from $this->db_table WHERE id = ?"))
        {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id);
            $stmt->fetch();

            if ($stmt->num_rows > 0)
            {
                $stmt->close();
                return TRUE;
            }
            $stmt->close();
            return FALSE;
        }
    }


    public function create_product_table($cols = 4, $category = NULL)
    {

        if ($category != NULL)
        {
            $products = $this->get_in_category($category);
        }
        else
        {
            $products = $this->get();
        }

        $data = '';

      
        {
            $i = 1;
            foreach ($products as $product)
            {
                $data .= '<li';
                if ($i == $cols)
                {
                    $data .= ' class="last"';
                    $i = 0;
                }
                $data .= '><a href="' . SITE_PATH . 'product.php?id=' . $product['id'] . '">';
                $data .= '<img src="' . IMAGE_PATH . $product['image'] . '" alt="' . $product['name'] . '"><br>';
                $data .= '<strong>' . $product['name'] . '</strong></a><br/>$' . $product['price'];
                $data .= '<br><a class="button_sml" href="' . SITE_PATH . 'cart.php?id=' . $product['id'] . '">Add to cart</a></li>';
                $i++;
            }
        }
        return $data;
    }
}