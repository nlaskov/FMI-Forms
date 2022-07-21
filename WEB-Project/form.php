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
    $form = load_form($token);
    $title = $form[0];
    $description = $form[1];
    $rows = $form[2];
    $is_owner = $form[3];
    $is_owned = $is_owner ? "true" : "false";
    $email = get_email($token);
    
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $stems_names = get_names_array($rows);
    $form_id = $_GET['form_id'];
    
    $json_entry = array();
    
    //Get array of answers
    foreach($stems_names as $i => $row) {
        $stem = $row[0];
        if($row[1] == "checkbox" || $row[1] == "checkbox" ){
            $answer = array();
            $check = $_POST[trim($row[2],"[]")];
            for($i=0;$i<count($check);$i++){
                array_push($answer,$check[$i]);
            }
            $json_entry[$stem]=$answer;  
        } else if($row[1] == "file"){
            if($_FILES[$row[2]]["error"] == UPLOAD_ERR_OK){
                $target = "answers/files/" . $form_id . "_" . basename($_FILES[$row[2]]["name"]);
                if(move_uploaded_file($_FILES[$row[2]]["tmp_name"], $target)){
                    $answer = basename($_FILES[$row[2]]["name"]);
                    $json_entry[$stem]=$answer;
                }
                else{
                    header("location:form?form_id=" . $_GET['form_id'] . "&error");
                }
            }
            else{
                 header("location:form?form_id=" . $_GET['form_id'] . "&error");
            }
        }
        else{
            $answer = $_POST[$row[2]];
            $json_entry[$stem]=$answer;
        }
    }
    
    //Check if there is existing answears from before
    $json_file = "answers/JSON/" . $email . "_". $form_id . ".json";
    
    if (file_exists($json_file)){
        $content = file_get_contents($json_file);
        
        $content = json_decode($content,true);
        $content[] = $json_entry;
        
    
        $file = fopen($json_file, "w") or die("Unable to open $json_file.");
    
        fwrite($file, trim(json_encode($content)));
        fclose($file);
         header("location:index");
    
    }
    else{
        $file = fopen($json_file, "w") or die("Unable to open $json_file.");
    
        $j = array();
        
        array_push($j,$json_entry);
        
        fwrite($file, trim(json_encode($j)));
        fclose($file);
         header("location:index");
    
    } 
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
    <link rel="stylesheet" href="css/form.css">
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
        <?php
        $delete_button ="<button class='btn' onclick='deleteForm(". '"' . $email . '"' . "," . '"' .$is_owned. '"' .")'>Delete form</button>";
        echo $delete_button;
        ?>
        <?php
        if(isset($_GET["error"])){
            echo "<div class='form_item'><p style='color:red'>There was an error. Pleace try again.</p></div>";
        }
        
        ?>

        <!-- Load every question -->
        <?php
        echo
            "<form id='form' class='form' method='POST' enctype='multipart/form-data'>
            <div class='quest'>
                <div class='title'>
                    <p>$title</p>
                </div>
                <div class = 'description'>
                    <p>$description</p>
                </div>
            </div>";
        
    $counter = 0;
    foreach($rows as $row){
        $res = split_inputs($row, $counter);
        $counter++;
        echo $res;
    }
                
                
        echo '
            <div class="btn-container">
                <button type="submit" name="submit" value="submit" class="btn">Submit</button>
            </div>
        </form>';
    ?>
    </main>
</body>
</html>