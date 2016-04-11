<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 4/1/16
 * Time: 2:29 PM
 */

session_start();
require_once '../model/users.php';

if(isset($_REQUEST['cmd'])){
    $cmd = intval($_REQUEST['cmd']);

    switch($cmd){

        case 1:
            //Add
            changePassword();
            break;
        case 2:
            //Update
            break;
        case 3:
            logout();
            break;

    }
}

function logout(){

    session_destroy();

    header('Location: ../customer_view/home.php');
}


function changePassword(){

    if(isset($_POST['pass']) & isset($_SESSION['cust_id'])){

        $pass = $_POST['pass'];
        $uid = intval($_SESSION['cust_id']);
        $user = new user();

        $user->setPassword($uid, $pass);

        logout();


    }
}