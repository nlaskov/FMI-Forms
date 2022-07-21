<?php
include "config.php";
include "php_scripts/auth.php";
include "php_scripts/queries.php";

$token = $_COOKIE['auth'];
$jwt = is_jwt_valid($token);

if($jwt){
    
    //$files = scandir(__DIR__);
    $files = scandir('generated/');
    $pairs = array();
    $email = get_email($token);
    $files_id = get_forms($db,$email);
    $ids = array();
    
    foreach($files_id as $form){
        foreach($form as $id){
            array_push($ids, $id);
            
        }
    }
    
    foreach ($files as $file) {
        if ($file != "." && $file != ".." ) {
          $key = trim($file, ".json");
        
          $key = trim($key, ".txt");
            if(in_array($key,$ids)){
                
                if (array_key_exists($key, $pairs)) {
                    array_push($pairs[$key], $file);
                } else {
                    $pairs[$key] = [$file];
                }
            }
        }
    }
    
} else {
    header("location: login");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Начало</title>
        <script src="js/transition.js"></script>
        <link rel="stylesheet" href="css/index.css">
    </head>
    
    
    
    <body class="page">
        <div class="logout-container">
            <button class="btn-small logout-btn" onclick="logout()">Logout</button>
        </div>
        <main>
        <div class="title">
         <h1 id="title"> Fmi Forms</h1>
        </div>
        <div class="main_btn">
            <button class="btn" onclick="newForm()">Create from text</button>
            <button class="btn" onclick="newFormUI()">Create from</button>
            <button class="btn" onclick="AddForm()">Add shared form</button>
        </div>
        
        <ol class="gradient-list">
            <?php
      foreach ($pairs as $key => $value) {
        if ($key != '') {
          $json_file = '';
          foreach ($value as $filename) {
            if (explode(".", $filename)[1] == "json") {
              $json_file = $filename;
            }
          }

          $title = "";
          $description = "";
          $creator = "";
          $last_edit = "";
          $function = "openForm";

          $file = file_get_contents("generated/$json_file");
          $json_content = json_decode($file, true);

          foreach ($json_content as $json_key => $value) {
            if ($json_key == "form_title") {
              $title = $value;
            } elseif ($json_key == "password") {
              $function = "openLoginForm";
            } elseif ($json_key == "form_description") {
              $description = $value;
            } elseif ($json_key == "creator") {
              $creator = $value;
            } elseif ($json_key == "last_edit") {
              $last_edit = $value;
            }
          }

          $edit_button = trim($creator) == get_email($token) ? "<button class='btn-small' onClick='editForm($key)'>Edit</button>" : '';
            
        $data_button = "<button class='btn-small' onClick='ShowData($key)'>Show data</button>";

          echo "<li id=$key>
                <div onclick='$function($key)'>
                  <p class='list-text'>$title</p>
                  <p class='list-text list-subtext'>Description: $description</p>
                  <p class='list-text list-subtext'>ID: $key</p>
                  <p class='list-text list-subtext'>Last edited: $last_edit</p>
                </div>
                $edit_button
                $data_button
              </li>";
        }
      }
      ?>
        </ol>
            </main>
    </body>
        
</html>