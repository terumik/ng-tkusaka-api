<?php
include('./Db.php');

header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json, charset=utf-8');

// get
$profile = $firebase->get('/profile');

echo $profile;
