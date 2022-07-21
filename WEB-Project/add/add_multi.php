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
        $res= "stem=" . $_POST["title"];
        $count = count($_POST) - 3;
        
        if(isset($_GET["checkbox"])){
            $res= $res .",type=checkbox,number_of_options=" . $count . ",name=" . $_POST["name"];
        }
        else{
            $res= $res .",type=radio,number_of_options=" . $count . ",name=" . $_POST["name"];
        }
         
        foreach($_POST as $key => $value){
            if(strpos($key,"option") !== FALSE){
                $res = $res . ",label=" . $value . ",value=" . $value;
            }
        }
        
        $res = $res . ";";
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
                <label class="title">Check field.</label>
            </div>
            <div class="quest">
                <label class="title">Add title.</label>
                <input class="input" name="title" required>
            </div>
            <div class="quest">
                <label class="title">Add name(Must be unique).</label>
                <input class="input" name="name" required>
            </div>
            <div id="options">
                <div class="quest option">
                    <label class="title">Option</label>
                    <input class="input" name="option1" required>
                </div>
            </div>

            <div class="quest">
                <button type="button" onclick="addOption()" class="btn-small">Add option</button>
            </div>


            <div class="btn-container">
                <button type="submit" name="submit" value="submit" class="btn">Submit</button>
            </div>
        </form>
    </main>
</body>
    <script type="text/javascript">
        function addOption(){
            
            var count = document.getElementsByClassName("option").length;
            count++;
            const option = document.createElement("div");
            option.classList.add("quest", "option");
            
            const label = document.createElement("label");
            label.classList.add("title");
            label.textContent = "Option";
            
            const input = document.createElement("input");
            input.classList.add("input");
            input.required = true;
            input.setAttribute('name',"option"+count);
            
            option.appendChild(label);
            option.appendChild(input);
            
            document.getElementById("options").appendChild(option)
            
            
        }
    </script>
</html>
