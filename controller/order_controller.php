<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/27/16
 * Time: 2:40 PM
 */

session_start();
require_once '../model/orders.php';

if(isset($_REQUEST['cmd'])){
    $cmd = intval($_REQUEST['cmd']);

    switch($cmd){

        case 1:
            //Add
            pay();
            break;
        case 2:
            //Update
            break;

    }
}

function pay(){
    if(isset($_POST['pay']) && isset($_POST['rid'])){
        $pay = $_POST['pay'];
        $card = $_POST['card'];
        $rid = $_POST['rid'];

        $orders = new orders();
        $res = $orders->updateReceipt($rid, $pay, $card);
        if($res != false){
            header("Location: ../view/admin_page/sales.php");
        }else{
            header("Location: ../view/admin_page/order_details.php?rid={$rid}");
        }
    }
}