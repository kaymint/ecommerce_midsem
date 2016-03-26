<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/26/16
 * Time: 1:14 PM
 */

/**
 * get all image s by category
 * and set all them according to category
 */

require_once '../model/furniture.php';

$furniture = new furniture();

//get categories
$result= $furniture->getCategories();
$categories = $result->fetch_all(MYSQLI_ASSOC);

$collection = array();

foreach($categories as $value){
    $res = $furniture->viewByCategory($value['category_id'], 'LIMIT 50');
    $collection[$value['category']] = $res->fetch_all(MYSQLI_ASSOC);
}

foreach($collection['Living room'] as $key=>$value){
    $no = $key+1;
    $image = "images/living/".$no.".png";
    $res = $furniture->updateImage($value['furniture_id'], $image);
}

foreach($collection['Bed Room'] as $key=>$value){
    $no = $key+1;
    $image = "images/bedroom/".$no.".png";
    $res = $furniture->updateImage($value['furniture_id'], $image);
}

foreach($collection['Bathroom'] as $key=>$value){
    $no = $key+1;
    $image = "images/bathroom/".$no.".png";
    $res = $furniture->updateImage($value['furniture_id'], $image);
}

foreach($collection['Kitchen'] as $key=>$value){
    $no = $key+1;
    $image = "images/kitchen/".$no.".png";
    $res = $furniture->updateImage($value['furniture_id'], $image);
}

foreach($collection['Business'] as $key=>$value){
    $no = $key+1;
    $image = "images/business/".$no.".png";
    $res = $furniture->updateImage($value['furniture_id'], $image);
}

foreach($collection['Outdoor'] as $key=>$value){
    $no = $key+1;
    $image = "images/outdoor/".$no.".png";
    $res = $furniture->updateImage($value['furniture_id'], $image);
}