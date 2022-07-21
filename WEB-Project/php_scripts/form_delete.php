<?php
include ("queries.php");
include ("../config.php");

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
$id = $_POST["id"];
$email = $_POST["email"];
$owner = $_POST["owner"];

if($owner == "true"){
    delete_form($db,$id);
    
    if (is_file("../generated/$id.json")) {
        unlink("../generated/$id.json") or die('An error occurred while deleting the json file.');
    } 
    
    if (is_file("../generated/$id.txt")) {
        unlink("../generated/$id.txt") or die('An error occurred while deleting the txt file.');
    }
}

if (is_file("../answers/JSON/$email" . "_" . "$id.json")) {
    unlink("../answers/JSON/$email" . "_" . "$id.json") or die('An error occurred while deleting the json file.');
}

delete_shared_form($db, $id, $email);
?>
