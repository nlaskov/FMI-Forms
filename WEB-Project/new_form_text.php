<?php

include "config.php";
include "php_scripts/auth.php";
include "php_scripts/generate.php";

$token = $_COOKIE['auth'];
$jwt_valid = is_jwt_valid($token);

if($jwt_valid){
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = get_email($_COOKIE['auth']);
        $errors = create_form_files($db,$email);
        if(count($errors) == 0){
            header("location: index");
        }
    }
} else{
    header("location:login");
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>New Form</title>
    <script src="js/new_form.js"></script>
    <link rel="stylesheet" href="css/new_form_text.css">
</head>
<main>

    <body class="page">
        <form method="POST">
            <div class="wrapper">
                <label class="label">JSON File</label>
                <textarea id="gform" name="gform"></textarea>
            </div>
            <div class="wrapper">
                <label class="label">Txt File</label>
                <textarea id="form-content" name="form-content"></textarea>
            </div>
            <div>
                <button type="submit">Create</button>
            </div>
        </form>
    </body>
</main>

</html>
