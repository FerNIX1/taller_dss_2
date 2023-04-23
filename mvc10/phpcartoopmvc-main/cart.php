<?php

include('app/init.php');
$Template->set_data('page_class', 'shoppingcart');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
  
    if ( ! $Products->product_exists($_GET['id']))
    {
        $Template->set_alert('Invalid item!');
        $Template->redirect(SITE_PATH . 'cart.php');
    }


    if (isset($_GET['num']) && is_numeric($_GET['num']))
    {
        $Cart->add($_GET['id'], $_GET['num']);
        $Template->set_alert('elementos agregados al carrito');
    }
    else
    {
        $Cart->add($_GET['id']);
        $Template->set_alert('elementos agregados');
    }
    $Template->redirect(SITE_PATH . 'cart.php');

}

if (isset($_GET['empty']))
{
    $Cart->empty_cart();
    $Template->set_alert('tajeta de compra vacia');
    $Template->redirect(SITE_PATH . 'cart.php');
}


$display = $Cart->create_cart();
$Template->set_data('cart_rows', $display);


$category_nav = $Categories->create_category_nav('');
$Template->set_data('page_nav', $category_nav);

$Template->load('app/views/v_public_cart.php', 'Shopping Cart');