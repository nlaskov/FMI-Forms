<?php

include "config.php";
include "php_scripts/queries.php";
include "php_scripts/parser.php";
include "php_scripts/auth.php";

header("Access-Control-Allow-Origin:*");
header("Access-Contol-Allow-Method:POST");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    $result = login_user($db, $email);
    $password_hash = $result[0]["password"];
    if(password_verify($password,$password_hash)){
         
        $_SESSION["login_user"] = $email;
        
        $headers = array( 'alg' => 'HS256', 'typ' => 'JWT');
        $expires = time() + 3600;
        $payload = array('email' => $email, 'exp' => ($expires));
       
        $jwt = generate_jwt($headers, $payload);
       
        setcookie('auth', $jwt, $expires, '/');
        
        header("location: index");
    } else{
        header("location: login?error");
    }
}
?>

<!DOCTYPE html>



<html>

<head>
    <meta charset="UTF-8">
    <title>Вход</title>
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
                <label for="email"><span>Email:</span></label>
                <input type="email" required name="email" id="email">
            </div>
            <div class="form_item">
                <label for="password"><span>Pasword:</span></label>
                <input type="password" required name="password" id="password">
            </div>
            <?php
            if(isset($_GET["error"])){
                echo "<div class='form_item'><p style='color:red'>Your email or password are invalid.</p></div>";
            }
            ?>
            <div class="form_item btn-container">
                <button type="submit" id="login-btn">Login</button>
            </div>
        </form>
        <button type="button" id="to-registration-btn" onclick="Registration()">Registration</button>

    </body>

</main>

</html>
