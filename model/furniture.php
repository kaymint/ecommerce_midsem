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
     * SEARCH QUERIES
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
                      ORDER BY F.brand_id
                      ";

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
                      AND C.category = ?
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
                      AND FT.furniture_type = ?
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
                      AND FT.furniture_type = ?
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


$product_info = array(
                array("name"=>"Edington", "brand"=>rand(1,15),
                    "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
                    "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
                array("name"=>"American Attitude", "brand"=>rand(1,15),
                    "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
                    "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Bancroft King", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Trevisco", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Kira", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Wyatt Media", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Cavallino", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Millenium Greensburg", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Konya", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Quinden", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Farrah", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Harlington", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Centennial LIV36", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Juararo", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Chilli Pepper Power", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic pepper pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Li Leather Longhorn Blackberry", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in Blackberry, brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Cooper Desert", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Murphy", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"St. Louis", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Porter", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Hawthorne Cooper", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Alder Creek", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Cooper Desert", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Mesh Porter", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Onyx", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Bayfield", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Walnut Heights", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Heights Cocktail", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Kianna", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Rhiannon Linen", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Jolene Leather", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Whitney", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Ottoman", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Becky II Ottoman", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Lucy Sette", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Faye Ottoman", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Shea Zed", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Mazzy Leather", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Daveigh", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Westwood Lisa", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Lisa Three-piece", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Geena Terri", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Tatiana Ottoman", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Zuma Linen", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Classic Lisa", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Quin Snow", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Celeste", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Kingston", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Iris", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Babette", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Charlie Linen", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Sadie Ottoman", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Heidi Medley", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Gigi Lisa", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000)),
    array("name"=>"Stacey Cafe", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, gold and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100.00, 30000.00), "qty"=>rand(1000, 10000)),
    array("name"=>"Turner", "brand"=>rand(1,15),
        "category"=>rand(1,6), "desc"=>"The classic leaf pattern in white, green and brown is old-fashioned and up-to-date at the same time. ",
        "type"=>rand(1,22), "image"=>'', "cost"=>rand(100, 400), "qty"=>rand(1000, 10000))

                );

$testObj = new furniture();
foreach($product_info as $value){
        echo $value['name'];
        $testObj->addFurniture($value['type'], $value['name'], $value['desc'], $value['category'],
            $value['brand'], $value['image']);
        $fid = $testObj->get_insert_id();
        echo $fid;
        $testObj->addInventoryDetails($fid, $value['qty'], $value['cost']);
}


//$types = array('sofa', 'armchair', 'coffee table', 'side table' ,
//    'bed', 'mattress', 'wardrobe', 'mirror', 'sink cabinet', 'sinks',
//    'faucet', 'island' ,'hammock', 'garden chair', 'patio seats');

//$brands = array('Agio', 'American', 'A.R.T.', 'Ashley', 'Aspen',
//    'Bernhardt', 'Boulevard', 'Brandington Young', 'Broyhill', 'Caracole',
//    'Fairmont', 'Craftmaster', 'Lane', 'Legacy Home', 'Magnussen Home',
//    'Michael Nicholas', 'Prime Resources', 'Pulsaki', 'Rachlin Classics',
//    'Sam Moore', 'Samuel Lawrence', 'Sauder', 'Simon Li', 'Stanley',
//    'Stressless', 'Stylecraft', 'Trendwood', 'Universal', 'USA', 'Violino',
//    'World Source', 'Hillsdale Furniture');


//$testObj = new furniture();
//$testObj->addFurnitureType('tv stand');
//
//foreach($brands as $value){
//    $testObj->addBrand($value);
//}

//$testObj->addInventoryDetails(1,300, 100);
//$testObj->addFurnitureType('Duvet');