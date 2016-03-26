<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/25/16
 * Time: 10:04 AM
 */

require_once 'shopping_cart_control.php';

if (isset($_GET['page'])) {
    $pageno = $_GET['page'];
} else {
    $pageno = 1;
}

require_once 'Twig-1.x/lib/Twig/Autoloader.php';

require_once '../model/furniture.php';

Twig_Autoloader::register();


$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template =$twig->loadTemplate('products.html.twig');
$params = array();

$furniture = new furniture();


function getResult($furniture){
    $value = array();
    if(isset($_REQUEST['vt'])) {

        $vt = intval($_REQUEST['vt']);
        $value['vt'] = $vt;

        switch ($vt) {
            case 1:
                //band
                if (isset($_REQUEST['cat'])) {
                    $cat = intval($_REQUEST['cat']);
                    $result = $furniture->getByCatCount($cat);
                    $value['pType'] = 'cat';
                    $value['pageIndex'] = $cat;
                    $value['result'] = $result;

                    return $value;
                }
                break;
            case 2:
                //category
                if (isset($_REQUEST['brand'])) {
                    $brand = intval($_REQUEST['brand']);
                    $result = $furniture->getByBrandCount($brand);
                    $value['pType'] = 'brand';
                    $value['pageIndex'] = $brand;
                    $value['result'] = $result;
                    return $value;
                }
                break;
            case 3:
                //all
                $result = $furniture->getStockCount();
                $value['result'] = $result;
                return $value;
                break;

        }
    }else{
        $result = $furniture->getStockCount();
        $value['result'] = $result;
        return $value;
    }
}


$value = getResult($furniture);

$result = $value['result'];

if(isset($value['pageIndex']) && isset($value['pType']) && isset($value['vt'])){
    $params['pageIndex'] = $value['pageIndex'];
    $params['pType'] = $value['pType'];
    $params['vt'] = $value['vt'];
}

$count = $result->fetch_assoc();
$numrows = $count['totalCount'];

//3
$rows_per_page = 15;
$lastpage      = ceil($numrows/$rows_per_page);

//4
$pageno = (int)$pageno;
if ($pageno > $lastpage) {
    $pageno = $lastpage;
} // if
if ($pageno < 1) {
    $pageno = 1;
} // if

$result = '';
//5
$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;

if(isset($_REQUEST['cmd'])){
    $cmd = intval($_REQUEST['cmd']);

    switch ($cmd){
        case 1:
            //view by category
            if(isset($_REQUEST['cat'])){
                $cat = intval($_REQUEST['cat']);
                $result = $furniture->viewByCategory($cat ,$limit);
                $params['pageType'] = 'cat';
            }

            break;
        case 2:
            //view by brandname
            if(isset($_REQUEST['brand'])){
                $brand = intval($_REQUEST['brand']);
                $result = $furniture->viewByBrandName($brand ,$limit);
                $params['pageType'] = 'brand';
            }
            break;
        case 3:
            break;
        case 4:
            break;
        default:
            $result = $furniture->viewStock($limit);
            $params['pageType'] = 'all';
            break;
    }
}else{
    $result = $furniture->viewStock($limit);
    $params['pageType'] = 'all';
}




//stock
$stock = $result->fetch_all(MYSQLI_ASSOC);
$params['furniture'] = $stock;

//categories
$result = $furniture->getCategories();
$cat = $result->fetch_all(MYSQLI_ASSOC);
$params['categories'] = $cat;


//brands
$result = $furniture->getBrands();
$brands = $result->fetch_all(MYSQLI_ASSOC);
$params['brands'] = $brands;




$params['currentPage'] = $_SERVER['PHP_SELF'];

//pages
$params['page'] = $pageno;
$params['totalPages'] = $lastpage;

if(isset($_SESSION['nItems'] )){
    $params['nItems'] = $_SESSION['nItems'];
}

$template->display($params);


