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
     * @return bool|mysqli_result
     */
    function getCategories(){
        //sql query
        $str_query = "SELECT * FROM categories";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @return bool|mysqli_result
     */
    function getBrands(){

        //sql query
        $str_query = "SELECT * FROM brands";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $cid
     * @return bool|mysqli_result
     */
    function getCustomerCart($cid){
        //sql query
        $str_query = "SELECT * FROM receipts R
                      INNER JOIN orders O
                      ON R.receipt_id = O.receipt_id
                      INNER JOIN furniture F
                      ON O.furniture_id = F.furniture_id
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      AND R.cust_id = ?
                      ORDER BY R.date_ordered DESC";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $cid);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $rid
     * @return bool|mysqli_result
     */
    function getReceiptDetails($rid){

        //sql query
        $str_query = "SELECT * FROM receipts R
                      INNER JOIN orders O
                      ON R.receipt_id = O.receipt_id
                      INNER JOIN furniture F
                      ON O.furniture_id = F.furniture_id
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      AND R.receipt_id = ?
                      ORDER BY R.date_ordered";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $rid);

        $stmt->execute();

        return $stmt->get_result();
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