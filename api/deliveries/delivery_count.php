<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/delivery.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $delivery = new Delivery($db);

    $delivery->captain = isset($_GET['captain']) ? $_GET['captain'] : die();

    $stmt = $delivery->deliveryCount();
    $num = $stmt->rowCount();
    
    // set response code - 200 OK
    http_response_code(200);
    
    // show deliveries data in json format
    echo json_encode($num);
