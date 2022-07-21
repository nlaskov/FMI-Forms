<?php

include "../config.php";
include "../php_scripts/auth.php";
include "../php_scripts/parser.php";
include "../php_scripts/generate.php";
include "../php_scripts/generate_answers.php";

//Auth check
$token = $_COOKIE['auth'];
$jwt = is_jwt_valid($token);

//Add load the form
if($jwt){
    $email = get_email($token);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $res= "stem=" . $_POST["title"] .",type=" . $_POST["type"]. ",name=" . $_POST["name"] . ",label=" . $_POST["name"] . ";";
        add_question($email,$res);
        
        header("location:../new_form_UI");
    }
    
}else {
    //If it isn`t valid go back to login
    header("location:../login");
}
?>

<!DOCTYPE html>


<html>

<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <link rel="stylesheet" href="../css/add_element.css">
    <script type="text/javascript" src="../js/transition.js"></script>
</head>

<body class="page">
    <main>
        <div class="title">
            <h1 id="title"> Fmi Forms</h1>
        </div>
        <form id='form' class='form' method='POST'>
            <div class="quest">
                <label class="title">Text, date, number field.</label>
            </div>
            <div class="quest">
                <label class="title">Add title.</label>
                <input class="input" name="title" required>
            </div>
            <div class="quest">
                <label class="title">Add name(Must be unique).</label>
                <input class="input" name="name" required>
            </div>
            
            <div class="quest">
                <label class="title">Choose type of field.</label>
                <select name="type">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="email">Email</option>
                     <option value="date">Date</option>
                    <option value="datetime-local">Datetime-local</option>
                    <option value="month">Month</option>
                    <option value="week">Week</option>                    
                </select>
            </div>
    
            <div class="btn-container">
                <button type="submit" name="submit" value="submit" class="btn">Submit</button>
            </div>
        </form>
    </main>
</body>
</html>