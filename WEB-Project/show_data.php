<?php

include "php_scripts/auth.php";
include "php_scripts/generate_answers.php";
$token = $_COOKIE['auth'];
$jwt = is_jwt_valid($token);

if($jwt){
    
    $id = $_GET["form_id"];
    $email = get_email($token);
    
    //Get answers
    $json_answers_file = $email . "_" . $id . ".json";
    if(!file_exists("answers/JSON/$json_answers_file")){
        header("location:index");
    }
    $json_answers_data = file_get_contents("answers/JSON/$json_answers_file");
    $json_answers_content = json_decode($json_answers_data, true);
    
    $txt_file = file_get_contents("generated/$id.txt");
    $quests = explode("\n",$txt_file);
    $types = array();
    foreach($quests as $quest){
        $temp = explode("=", explode(",",$quest)[1])[1];
        array_push($types,$temp);
    }
    
    
    $answers = array();
    
    foreach($json_answers_content as $temp){
        foreach($temp as $key => $value){
            if(array_key_exists($key,$answers)){
                array_push($answers[$key],$value);
            }
            else{
                $answers[$key] = array();
                array_push($answers[$key],$value);
            }
        }
    }
    
    //Get info json
    
    $json_file = $id . ".json";
    if(!file_exists("generated/$json_file")){
        header("location:index");
    }
    
    $json_data = file_get_contents("generated/$json_file");
    $json_content = json_decode($json_data, true);
    
    $title = $json_content["form_title"];
    $description = $json_content["form_description"];
    $created_by = $json_content["creator"];
}
else{
    header("locatio:login");
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <link rel="stylesheet" href="css/show_data.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">

    </script>
</head>
<main>

    <body class="page">

        <?php
        echo
        "<div id='form' class='form'>
            <div class='quest'>
                <div class='title'>
                    <p>$title</p>
                </div>
                <div class = 'description'>
                    <p>$description</p>
                </div>
                <div class = 'creator'>
                    <p>Created by:$created_by</p>
                </div>
            </div>
            <div class='quest'>
                <a href='answers/JSON/". $email ."_" . $id . ".json' download='". $title . ".json' class='btn-small link'>Download data</a>
            </div>
            
            ";
        $counter=0;
    foreach($answers as $question => $answer){
        $res = generate_answer($_GET["form_id"],$question,$answer,$types[$counter]);
        $counter++;
        echo $res;
    }
        echo" </form>";
        
        ?>


    </body>
</main>

<script>
    function showData(title) {
        var display = document.getElementById(title).style.display;
        if (display == "") display = "none";
        if (display == "none") {
            document.getElementById(title).style.display = "block";
        } else {
            document.getElementById(title).style.display = "none";
        }
    }

</script>

</html>
