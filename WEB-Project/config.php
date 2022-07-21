<?php 

include "env.php";

$db = new mysqli($_ENV["SERVERNAME"],$_ENV["USERNAME"],$_ENV["PASSWORD"],$_ENV["DATABASE"]);

if ($db->connect_error){
    die("Connection error:" . $db->connect_error);
}

?>