<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/24/16
 * Time: 12:21 AM
 */


require_once 'adb_object.php';

class orders extends adb_object
{

    /**
     * furniture constructor.
     */
    function __construct()
    {
        parent:: __construct();
    }

    /**
     * *********************************************************
     * INSERT QUERIES
     * *********************************************************
     */

    /**
     * @param $cid
     * @param $total
     * @param $address
     * @param $phone
     * @return bool|mysqli_stmt
     */
    function addReceipt($cid, $total, $address, $phone)
    {

        $paid = 'UNPAID';
        $date = date("Y-m-d h:i:s");


        //sql query
        $str_query = "INSERT INTO receipts(cust_id, date_ordered, total_cost, paid, shipping_address, phone)
                      VALUES (?, ?, ?, ?,?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("isdsss", $cid, $date, $total, $paid, $address, $phone);


        $stmt->execute();

        return $stmt;
    }



    /**
     * @param $recId
     * @param $fId
     * @param $cid
     * @param $cost
     * @return bool|mysqli_stmt
     */
    function addOrder($recId, $fId, $cid, $cost){

        //sql query
        $str_query = "INSERT INTO orders(receipt_id, furniture_id, cust_id, cost)
                      VALUES (?, ?, ?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("iiid", $recId, $fId, $cid, $cost);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $recId
     * @param $card
     * @param $payment
     * @return bool|mysqli_stmt
     */
    function updateReceipt($recId, $card, $payment){

        //sql query
        $str_query = "UPDATE receipts
                      SET
                      paid = ?,
                      payment_type = ?,
                      card_no = ?,
                      date_paid = ?
                      WHERE receipt_id = ?";

        $stmt = $this->prepareQuery($str_query);

        $paid = 'PAID';
        $date = date("Y-m-d h:i:s");

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("ssssi", $paid, $payment, $card, $date, $recId);


        $stmt->execute();

        return $stmt;
    }


}