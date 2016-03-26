<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/26/16
 * Time: 10:58 AM
 */

require_once '../model/furniture.php';

$searchValues = array();

if(isset($_REQUEST['scmd'])){

    $scmd = intval($_REQUEST['scmd']);

    switch($scmd){

        case 1:
            //simple search
            if(isset($_REQUEST['st'])){


            }
            break;
        case 2:
            //advanced search
            if(isset($_REQUEST['stbrand']) || isset($_REQUEST['stcat']) || isset($_REQUEST['stname'])){

            }
            break;
    }

}