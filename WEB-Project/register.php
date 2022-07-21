<?php

include "config.php";
include "php_scripts/queries.php";
include "php_scripts/parser.php";
            

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email_err= $password_err = $param_email=$param_password=$param_fk= $param_name="";
    
    $res = check_email($db,$_POST["email"]);
    
    if(!$res){
        header("location:register?error1");
    }
    
    $res = validate_password($_POST["password"]);
    
    if(!$res){
        header("location:register?error2");
    }
    
    $res = validate_confirm_password($_POST["confirm_password"], $_POST["password"]);
    if(!$res){
        header("location:register?error3");
    }
    
    //register_user($db, $param_email, $param_password, $param_fk, $param_name, trim($_POST["email"]), trim($_POST["password"]));
    //header("location:login");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/login_and_regis.css">
    <script type="text/javascript" src="js/transition.js"></script>
</head>
<main>
    <header>
        <h1 class="title">FMI Forms</h1>
    </header>

    <body class="page">
        <form method="POST" id="form">
            <div class="form_item">
                <label for="name"><span>Name:</span></label>
                <input type="text" required name="name" id="email">
            </div>
            <div class="form_item">
                <label for="email"><span>Email:</span></label>
                <input type="email" required name="email" id="email">
            </div>
            
            <?php
            if(isset($_GET["error1"])){
                echo "<div class='form_item'><p style='color:red'>This email is already used!</p></div>";
            }
            ?>
            
            <div class="form_item">
                <label for="fn"><span>FN:</span></label>
                <input type="text" required name="fn" id="email">
            </div>

            <div class="form_item">
                <label for="password" minlength="6"><span>Password:</span></label>
                <input type="password" required name="password" id="password">
            </div>
            
            <?php
            if(isset($_GET["error2"])){
                echo "<div class='form_item'><p style='color:red'>Password should be at least 6 characters long!</p></div>";
            }
            ?>
            
            <div class="form_item">
                <label for="confirm_password"><span>Confirm password:</span></label>
                <input type="password" required name="confirm_password" id="password">
            </div>
            
            <?php
            if(isset($_GET["error3"])){
                echo "<div class='form_item'><p style='color:red'>Password doesn`t match!</p></div>";
            }
            ?>

            <div class="form_item btn-container">
                <button type="submit" id="login-btn">Registration</button>
            </div>
            
            

        </form>
        <button type="button" id="to-registration-btn" onclick="Login()">Login</button>

    </body>

</main>

</html>
