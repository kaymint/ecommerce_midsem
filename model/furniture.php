<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/24/16
 * Time: 12:21 AM
 */

require_once 'adb_object.php';

class furniture extends adb_object{

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
     * @param $type
     * @param $name
     * @param $description
     * @param $category
     * @param $image
     * @return bool|mysqli_stmt
     */
    function addFurniture($type, $name, $description, $category, $brand,$image){

        //sql query
        $str_query = "INSERT INTO furniture(furniture_type, name, description, brand_id, category, image)
                      VALUES (?, ?, ?, ?,?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("issiis", $type, $name, $description, $brand,$category, $image);


        $stmt->execute();

        return $stmt;
    }

    /**
     * Add inventory details
     *
     * @param $fid
     * @param $onhand
     * @param $cost
     * @return bool|mysqli_stmt
     */
    function addInventoryDetails($fid, $onhand, $cost){

        //sql query
        $str_query = "INSERT INTO inventory(furniture_id, onhand, cost, date_added)
                      VALUES (?, ?, ?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $date = date("Y-m-d h:i:s");

        $stmt->bind_param("iids", $fid, $onhand, $cost, $date);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $type
     * @return bool|mysqli_stmt
     */
    function addFurnitureType($type){

        //sql query
        $str_query = "INSERT INTO furniture_type(furniture_type) VALUES (?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $type);


        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $cat
     * @return bool|mysqli_stmt
     */
    function addCategory($cat){

        //sql query
        $str_query = "INSERT INTO categories(category) VALUES (?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $cat);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $name
     * @return bool|mysqli_stmt
     */
    function addBrand($name){

        //sql query
        $str_query = "INSERT INTO brands(brand_name) VALUES (?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $name);

        $stmt->execute();

        return $stmt;
    }


    /**
     * *********************************************************
     * UPDATE QUERIES
     * *********************************************************
     */

    /**
     * @param $cost
     * @return bool|mysqli_stmt
     */
    function updateCost($fid, $cost){
        //sql query
        $str_query = "UPDATE inventory
                      SET
                      cost = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("di", $cost, $fid);


        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $fid
     * @return bool|mysqli_stmt
     */
    function updateDate($fid){

        //sql query
        $str_query = "UPDATE inventory
                      SET
                      date_added = ?
                      WHERE furniture_id = ?";

        $date = date("Y-m-d h:i:s");

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("si", $date, $fid);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $fid
     * @param $qty
     * @return bool|mysqli_stmt
     */
    function updateQuantity($fid, $qty){

        //sql query
        $str_query = "UPDATE inventory
                      SET
                      onhand = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("ii", $qty, $fid);


        $stmt->execute();

        return $stmt;
    }


    /**
     * *********************************************************
     * SELECT QUERIES
     * *********************************************************
     */

    /**
     * @param $fid
     * @return bool|mysqli_result
     */
    function getProduct($fid){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.furniture_id = ?
                      ORDER BY F.brand_id";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $fid);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $limit
     * @return bool|mysqli_result
     */
    function viewStock($limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $brand
     * @param $limit
     * @return bool|mysqli_result
     */
    function viewByBrandName($brand, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND B.brand_name = ?
                      ORDER BY F.brand_id
                      ";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $brand);

        $stmt->execute();

        return $stmt->get_result();
    }


    function viewByCategory($cat, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND C.category = ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $cat);

        $stmt->execute();

        return $stmt->get_result();
    }


    function viewByType($type, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND FT.furniture_type = ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $type);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * ***************************************************
     * SEARCH QUERIES
     * ***************************************************
     */

    /**
     * @param $brand
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByBrandName($brand, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND B.brand_name LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $brand = "%{$brand}%";

        $stmt->bind_param("s", $brand);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $cat
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByCategory($cat, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND C.category LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $cat = "%{$cat}%";

        $stmt->bind_param("s", $cat);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $type
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByType($type, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND FT.furniture_type LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $type = "%{$type}%";

        $stmt->bind_param("s", $type);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $name
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByName($name, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.name LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $name = "%{$name}%";

        $stmt->bind_param("s", $name);

        $stmt->execute();

        return $stmt->get_result();
    }

}


$testObj = new furniture();



$row = $result->fetch_all(MYSQLI_ASSOC);

var_dump($row);


