<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/24/16
 * Time: 12:21 AM
 */

require_once 'adb_object.php';

class user extends adb_object{

    function __construct()
    {
        parent::__construct();
    }


    /**
     * @param $username
     * @param $password
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $address
     * @param $birthdate
     * @param $phone
     * @param $title
     * @param $city
     * @return bool|mysqli_stmt
     */
    function addUser($username, $password, $firstname, $lastname,
                     $email, $address, $birthdate, $phone, $title, $city){

        $password = encrypt($password);
        //sql query
        $str_query = "INSERT INTO customer(username, password, firstname, lastname,
                      email, address, birthdate, phone, title, city)
                      VALUES (?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("ssssssssss", $username, $password, $firstname, $lastname, $email, $address,
            $birthdate, $phone, $title, $city);


        $stmt->execute();

        return true;
    }

    /**
     * @param $username
     * @param $password
     * @return bool|mysqli_result
     */
    function loginUser($username , $password){

        $password = encrypt($password);

        $str_query = "SELECT DISTINCT * FROM ecommerce_furniture.customer WHERE username = ? and password = ?
                      OR customer.email = ? and password = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("ssss", $username, $password, $username, $password);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $uid
     * @param $pass
     * @return bool|mysqli_stmt
     */
    function setPassword($uid, $pass){

        $password = encrypt($pass);
        //sql query
        $str_query = "UPDATE customer
                     SET
                     password = ?
                     WHERE cust_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("si", $password, $uid);


        $stmt->execute();

        return $stmt;
    }
}


function encrypt($pass){
    return md5($pass);
}


//$testObj = new user();
//$testObj->addUser('S.Mensah','S.Mensah', 'Sally',
//    'Mensah','gsm@gmail.com','122 New Weija', '1963-05-06', '233200393945', 'MRS', 'Accra');

//addUser($username, $password, $firstname, $lastname,
//    $email, $address, $birthdate, $phone, $title, $city);


//$result = $testObj->loginUser('gsm@gmail.com', 'S.Mensah');
//$row = $result->fetch_assoc();
//var_dump($row);
//
//if(count($row[0]) == 0){
//    echo 'invalid user';
//}else{
//    echo 'valid user';
//}

//$pass = $row[0]['password'];


//$testObj->addAdmin('N.Amanquah', 'N.Amanquah', 'Nathan', 'Amanquah');