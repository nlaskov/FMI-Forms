<?php
include "config.php";
include "php_scripts/auth.php";
include "php_scripts/generate.php";

$token = $_COOKIE['auth'];
$jwt = is_jwt_valid($token);

if($jwt){
    $form = load_form($token);
    $title = $form[0];
    $description = $form[1];
    $need_password = $form[4];
    $password = $form[5];
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $pass = $_POST["password"];
        
        if($password == $pass){
            $id = $_GET["form_id"];
            header("location: form?form_id=$id");
        }
    }
}
else{
    header("location:login");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Form-password</title>
    <link rel="stylesheet" href="css/form_with_pass.css">
</head>

<main>

    <body class="page">
        <form id='form' method='POST'>
            
            <?php
            echo "<div class='form_item'>
                    <label class='info'>$title</p>
                </div>
                <div class='form_item'>
                    <label class='info'>$description</p>
                </div>
                ";
            ?>
            
            <div class="form_item">
                <label htmlFor="password">Password</label>
                <input type="password" name="password" id="password" required />
            </div>
            <div class="form_item btn-container">
                <button type="submit" name="submit" value="submit" class="btn">Submit</button>
            </div>
        </form>
    </body>
</main>

</html>
