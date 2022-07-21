<?php
include "config.php";
include "php_scripts/auth.php";
include "php_scripts/generate.php";


//Auth check
$token = $_COOKIE['auth'];
$jwt = is_jwt_valid($token);

//If it isn`t valid go back to login
if(!$jwt){
    header("location:login");
}
else{
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = get_email($token);
        $form_id = $_POST["id"];
    
        if(check_form($db,$form_id)){
            add_shared_form($db,$email,$form_id);
            header("location:index");
        }
        else{
            header("location:add_form?error");
        }
        
    }
}




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Add form</title>
    <link rel="stylesheet" href="css/add_form.css">
    <script type="text/javascript" src="js/transition.js"></script>
</head>


<div class="logout-container">
    <button class="btn-small logout-btn" onclick="logout()">Logout</button>
</div>

<body class="page">
    <main>
        <div class="title">
            <a id="title" href="index"> Fmi Forms</a>
        </div>
        <form id='form' method='POST'>
            <div class="form_item">
                <label htmlFor="id">Form ID</label>
                <input type="next" name="id" id="id" required />
            </div>
            <?php 
                    if(isset($_GET["error"])){
                        echo "<div class='form_item'><p style='color:red'>Can`t add this form.</p></div>";
                    }
                ?>
            <div class="form_item btn-container">
                <button type="submit" name="submit" value="submit" class="btn">Add</button>
            </div>
        </form>
    </main>
</body>

</html>
