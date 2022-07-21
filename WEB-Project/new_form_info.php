<?php

include "config.php";
include "php_scripts/auth.php";
include "php_scripts/parser.php";
include "php_scripts/generate.php";
include "php_scripts/generate_answers.php";

//Auth check
$token = $_COOKIE['auth'];
$jwt = is_jwt_valid($token);

//Add load the form
if($jwt){
    $email = get_email($token);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        $content=array();
        
        $content["form_title"] = $_POST['title'];
        $content["form_description"] = $_POST['description'];
        if($_POST["password"] != ""){
            $content["password"] = $_POST['password'];
        }
        
        generate_work_file_json($content,$email);
        
        header("location:new_form_UI");
    }
    
}else {
    //If it isn`t valid go back to login
    header("location:login");
}
?>

<!DOCTYPE html>


<html>

<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <link rel="stylesheet" href="css/new_form_info.css">
    <script type="text/javascript" src="js/transition.js"></script>
    <script type="text/javascript" src="js/delete_form.js"></script>
</head>

<body class="page">
    <div class="logout-container">
        <button class="btn-small logout-btn" onclick="logout()">Logout</button>
    </div>
    <main>
        <div class="title">
            <a id="title" href="index"> Fmi Forms</a>
        </div>
        <form id='form' class='form' method='POST'>
            <div class='quest'>
                <input class="input" type="text" name="title" placeholder="Title" required>
                <input class="input" type="text" name="description" placeholder="Description" required>
                <input class="input" type="text" name="password" placeholder="Password">
            </div>
            <div class="btn-container">
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>
    </main>
</body>
</html>