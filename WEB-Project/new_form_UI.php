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
    $quests = load_work_file_txt($email);
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    set_permanent($db, $email);
    
    header("location:index");
    
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
    <link rel="stylesheet" href="css/new_form_UI.css">
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
        
        <div class="dropdown">
                <button class=" btn">Add question</button>
                <div class="dropdown-content">
                    <a href="add/add_text">Text</a>
                    <a href="add/add_multi?radio">Radio buttons</a>
                    <a href="add/add_multi?checkbox">Check buttons</a>
                    <a href="add/add_file">File</a>
                    <a href="add/add_range">Range</a>
                </div>
            </div>

        <!-- Load every question -->
        <?php
        echo "<form id='form' class='form' method='POST'>";
        foreach($quests as $quest){
            if ($quest!= ""){
                $res = split_inputs_disabled($quest);
                echo $res;
            }
        }
        ?>
        <div class="btn-container">
            <button type="submit" name="submit" value="submit" class="btn">Submit</button>
        </div>

        <?php 
        echo '</form>';
        ?>
    </main>
</body>

</html>
