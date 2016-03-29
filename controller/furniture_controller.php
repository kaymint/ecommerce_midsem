<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/27/16
 * Time: 3:43 AM
 */
session_start();
require_once '../model/furniture.php';

if(isset($_REQUEST['cmd'])){
    $cmd = intval($_REQUEST['cmd']);

    switch($cmd){

        case 1:
            //Add
            addInventory();
            break;
        case 2:
            //Update
            updateInventory();
            break;


    }
}


function updateInventory(){
    if(isset($_POST['type']) && isset($_POST['name']) && isset($_POST['brand'])
        && isset($_POST['cat']) && isset($_POST['fid'])){

        $furniture = new furniture();

        $fid = intval($_POST['fid']);
        $type = $_POST['type'];
        echo "type :".$type;
        $brand = $_POST['brand'];
        echo "brand :".$brand;
        $cat = $_POST['cat'];
        echo "id :".$cat;
        $name = $_POST['name'];
        $image = '';
        if(isset($_SESSION['filepath'])){
            $image = $_SESSION['filepath'];
        }
        $qty = $_POST['onhand'];
        $cost = $_POST['cost'];
        $desc = $_POST['desc'];




        $furniture->addFurniture($type, $name, $desc, $cat,$brand, $image);
        $fid = $furniture->get_insert_id();
        $res = $furniture->addInventoryDetails($fid, $qty,  $cost);

        if($res != false){
            $_SESSION['message'] = 'Added Succesfully';
            header("Location: ../view/admin_page/home.php");
        }else{
            $_SESSION['message'] = 'Add Unsuccesful';
            header("Location: ../view/admin_page/home.php");
        }
    }
}

function addInventory(){


    if(isset($_POST['type']) && isset($_POST['name']) && isset($_POST['brand'])
        && isset($_POST['cat'])){

        $furniture = new furniture();

        $type = $_POST['type'];
        echo "type :".$type;
        $brand = $_POST['brand'];
        echo "brand :".$brand;
        $cat = $_POST['cat'];
        echo "id :".$cat;
        $name = $_POST['name'];
        $image = '';
        if(isset($_SESSION['filepath'])){
            $image = $_SESSION['filepath'];
        }
        $qty = $_POST['onhand'];
        $cost = $_POST['cost'];
        $desc = $_POST['desc'];




        $furniture->addFurniture($type, $name, $desc, $cat,$brand, $image);
        $fid = $furniture->get_insert_id();
        $res = $furniture->addInventoryDetails($fid, $qty,  $cost);

        if($res != false){
            $_SESSION['message'] = 'Added Succesfully';
            header("Location: ../view/admin_page/add.php");
        }else{
            $_SESSION['message'] = 'Add Unsuccesful';
            header("Location: ../view/admin_page/add.php");
        }
    }
}