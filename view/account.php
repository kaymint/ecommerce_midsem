<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/26/16
 * Time: 9:36 AM
 */

require_once 'shopping_cart_control.php';

require_once 'Twig-1.x/lib/Twig/Autoloader.php';

require_once '../model/furniture.php';

require_once '../model/users.php';

Twig_Autoloader::register();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template =$twig->loadTemplate('customer_account.html.twig');
$params = array();


if(isset($_SESSION['cust_id'])){
    $params['username'] = $_SESSION['username'];
    $params['fname'] = $_SESSION['fname'];
    $params['lname'] = $_SESSION['lname'];
    $params['email'] = $_SESSION['email'];
    $params['address'] = $_SESSION['address'];
    $params['phone'] = $_SESSION['phone'];
    $params['title'] = $_SESSION['title'];
}







$template->display($params);