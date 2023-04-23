<?php


$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'ks_shop';
$Database = new mysqli($server, $user, $pass, $db);


mysqli_report(MYSQLI_REPORT_ERROR);
ini_set('display_errors', 1);


define('SITE_NAME', 'La despensa');
define('SITE_PATH', 'http://localhost/mvc10/phpcartoopmvc-main/');
define('IMAGE_PATH', 'http://localhost/mvc10/phpcartoopmvc-main/resources/images/');


include('app/models/m_template.php');
include('app/models/m_categories.php');
include('app/models/m_products.php');
include('app/models/m_cart.php');


$Template = new Template();
$Categories = new Categories();
$Products = new Products();
$Cart = new Cart();

session_start();