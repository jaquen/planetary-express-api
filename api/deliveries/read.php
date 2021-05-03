<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/delivery.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$delivery = new Delivery($db);

// query deliveries
$stmt = $delivery->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // deliveries array
    $deliveries_arr=array();
    $deliveries_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $delivery_item=array(
            "id" => $id,
            "captain" => $captain,
            "ship" => $ship,
            "destination" => $destination,
            "completed" => $completed
        );
  
        array_push($deliveries_arr["records"], $delivery_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show deliveries data in json format
    echo json_encode($deliveries_arr);
} else {
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no deliveries found
    echo json_encode(
        array("message" => "No deliveries found.")
    );
}
