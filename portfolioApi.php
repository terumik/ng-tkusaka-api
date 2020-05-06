<?php
include('./Db.php');

header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json, charset=utf-8');

// get
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $portfolio = $firebase->get("/portfolio/$id");
    echo $portfolio;
} else {
    $data = $firebase->get('/portfolio');
    // omit null value on 0 index
    $decode = json_decode($data);
    $portfolios = array_slice($decode, 1); 
    echo json_encode($portfolios);
}