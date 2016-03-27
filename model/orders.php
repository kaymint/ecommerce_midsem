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
     * @param $address2
     * @param $rec_fname
     * @param $rec_lname
     * @param $rec_email
     * @param $rec_country
     * @param $rec_compname
     * @return bool|mysqli_stmt
     */
    function addReceipt($cid, $total, $address, $phone, $address2, $rec_fname, $rec_lname,
                        $rec_email, $rec_country, $rec_compname)
    {

        $paid = 'UNPAID';
        $date = date("Y-m-d h:i:s");


        //sql query
        $str_query = "INSERT INTO receipts(cust_id, date_ordered, total_cost, paid, shipping_address, phone,
                              shipping_address2, receiver_firstname, receiver_lastname, receiver_email, country,
                              company_name)
                      VALUES (?, ?, ?, ?,?, ?,?, ?, ?, ?,?, ? )";

        $stmt = $this->prepareQuery($str_query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("isdsssssssss", $cid, $date, $total, $paid, $address, $phone,$address2, $rec_fname,
            $rec_lname, $rec_email, $rec_country, $rec_compname );


        $stmt->execute();

        return $stmt;
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
    function addOrder($recId, $fId, $cid, $cost , $qty){

        //sql query
        $str_query = "INSERT INTO orders(receipt_id, furniture_id, cust_id, cost, qty)
                      VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("iiidi", $recId, $fId, $cid, $cost, $qty);


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

    /**
     * @return bool|mysqli_result
     */
    function getNumOrders(){
        //sql query
        $str_query = "SELECT COUNT(*) AS numOrders FROM orders";

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
    function getNumSales(){
        //sql query
        $str_query = "SELECT COUNT(*) AS numSales FROM receipts WHERE paid=PAID";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }



}