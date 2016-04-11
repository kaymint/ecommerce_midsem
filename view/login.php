<?php
error_reporting(E_ERROR | E_PARSE);
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/25/16
 * Time: 3:58 PM
 */

require_once 'shopping_cart_control.php';

require_once 'Twig-1.x/lib/Twig/Autoloader.php';

require_once '../model/furniture.php';

require_once '../model/users.php';

Twig_Autoloader::register();


$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template =$twig->loadTemplate('login.html.twig');
$params = array();

$params['currentPage'] = $_SERVER['PHP_SELF'];

if(isset($_SESSION['nItems'] )){
    $params['nItems'] = $_SESSION['nItems'];
}

$user = new user();

if(isset($_REQUEST['cmd'])){
    $cmd = intval($_REQUEST['cmd']);

    switch($cmd){
        case 1:
            //login
            if(isset($_POST['username']) && isset($_POST['password'])){
                $uname = $_POST['username'];
                $pass = $_POST['password'];
                $result = $user->loginUser($uname, $pass);
                $row = $result->fetch_assoc();
                if(count($row) == 0){
                    $params['warning'] = 'Invalid User';
                }else{
                    $_SESSION['cust_id'] = $row['cust_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['fname'] = $row['firstname'];
                    $_SESSION['lname'] = $row['lastname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['address'] = $row['address'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['title'] = $row['title'];
                    header('Location: home.php');
                }
            }
            break;
        case 2:
            //signup
            if(isset($_POST['username']) && isset($_POST['email']) &&
            isset($_POST['phone']) && isset($_POST['password']) &&
            isset($_POST['address']) && isset($_POST['fname']) &&
                isset($_POST['lname'])){

                $username = $_POST['username'];
                $pass = $_POST['password'];
                $pass2 = $_POST['password2'];
                $address = $_POST['address'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $bdate = $_POST['bdate'];
                $phone = $_POST['phone'];
                $title = $_POST['title'];
                $city = $_POST['city'];

                if(strcmp($pass,$pass) != 0){
                    $params['warning'] = 'Passwords are not the same';
                }else{
                    $res = $user->addUser($username, $pass, $fname, $lname,$email,$address, $bdate,
                        $phone, $title, $city);
                    if($res){
                        $_SESSION['cust_id'] = $row['cust_id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['fname'] = $row['firstname'];
                        $_SESSION['lname'] = $row['lastname'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['address'] = $row['address'];
                        $_SESSION['phone'] = $row['phone'];
                        $_SESSION['title'] = $row['title'];
                        header('Location: home.php');
                    }
                }


            }

        break;
    }
}

$template->display($params);