<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/delivery.php';

$database = new Database();
$db = $database->getConnection();

$delivery = new Delivery($db);

// get posted data & check that it's not empty
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->captain) &&
    !empty($data->ship) &&
    !empty($data->destination)
){
  
    // set delivery property values
    $delivery->captain = $data->captain;
    $delivery->ship = $data->ship;
    $delivery->destination = $data->destination;
    $delivery->completed = $data->completed;
  
    // create the delivery
    if($delivery->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Delivery was created."));
    }
  
    // if unable to create the delivery, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create delivery."));
    }
}
  
// tell the user data is incomplete
else{
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create delivery. Data is incomplete."));
}
?>
