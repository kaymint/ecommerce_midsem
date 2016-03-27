<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/27/16
 * Time: 1:30 AM
 */

require_once '../Twig-1.x/lib/Twig/Autoloader.php';

require_once '../../model/furniture.php';

require_once '../../model/orders.php';

Twig_Autoloader::register();


$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template =$twig->loadTemplate('add.html.twig');
$params = array();

$furniture = new furniture();
$orders = new orders();


//get orders
$result = $orders->getNumOrders();
$nOrders = $result->fetch_assoc();
$params['order_count'] = $nOrders['numOrders'];


//get sales
$result = $orders->getNumOrders();
$nSales = $result->fetch_assoc();
$params['sales_count'] = $nOrders['numSales'];


//categories
$result = $furniture->getCategories();
$cat = $result->fetch_all(MYSQLI_ASSOC);
$params['categories'] = $cat;

//brands
$result = $furniture->getBrands();
$brands = $result->fetch_all(MYSQLI_ASSOC);
$params['brands'] = $brands;

//types
$result = $furniture->getTypes();
$types = $result->fetch_all(MYSQLI_ASSOC);
$params['types'] = $types;


$params['currentPage'] = $_SERVER['PHP_SELF'];

$template->display($params);