<?php

/* get_product_details.php */
 
/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */
 
 header('Content-Type: text/html; charset=utf-8');
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// check for post data
if (isset($_GET["pid"])) {
    $pid = $_GET['pid'];
 
    // get a product from products table
	mysql_query("SET NAMES 'utf8'");
    $result = mysql_query("SELECT * FROM products WHERE pid = $pid");
 
    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
 
            $result = mysql_fetch_array($result);
 
            $product = array();
            $product["pid"] = $result["pid"];
            $product["name"] = $result["name"];
            $product["price"] = $result["price"];
            $product["description"] = $result["description"];
            $product["created_at"] = $result["created_at"];
            $product["updated_at"] = $result["updated_at"];
            // success
            $response["success"] = 1;
 
            // user node
            $response["product"] = array();
 
            array_push($response["product"], $product);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No product found";
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No product found";
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
}

// echoing JSON response
echo json_encode($response);
?>