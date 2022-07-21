<?php
include ("queries.php");
function create_form_files($db,$email)
{
    $errors = [];
    
    $json_content = json_decode($_POST["gform"], true);
    $title = $json_content["form_title"];
    $description = $json_content["form_description"];
    $form_id = $_GET["form_id"];
    if ($form_id == null){
        $form_id = add_form($db, $email, $title, $description);
    }
    
    
    $filename = "generated/$form_id.txt";
    $json_settings = "generated/$form_id.json";

    if (trim($_POST["form-content"]) == "") {
        $errors["content"] = "Content is required.";
    }

    if (trim($title) == "") {
        $errors["title"] = "Title is required.";
    }

    if (!isJson(trim($_POST["gform"]))) {
        $errors["settings"] = "Please provide a valid JSON";
    }
    if (is_file($filename)) {
          unlink($filename) or die('An error occurred while deleting the txt file.');
        
    } 

    if (is_file($json_settings)) {
          unlink($json_settings) or die('An error occurred while deleting the json file.');
        
    }
    

    if (count($errors) == 0) {
        if (!file_exists($filename)) {
            $file = fopen($filename, "w") or die("Unable to open file.");
            fwrite($file, trim($_POST["form-content"]));
            fclose($file);
        }
        if (!file_exists($json_settings)) {
            $file = fopen($json_settings, "w") or die("Unable to open file.");
            $json_content["creator"] = $email;
            $json_content["last_edit"] = date("l jS \of F Y h:i:s A");
            fwrite($file, trim(json_encode($json_content)));
            fclose($file);
        }
    }
    return $errors;
}

function load_form($token){
    $form_id = $_GET["form_id"];
    
    $json = "";
    $txt = "";
    $title = "";
    $description = "";
    $password="";
    $delete_button = false;
    $need_password = false;
    
    $files = scandir("generated/");
    
    foreach($files as $file){
        if($file == "$form_id.txt"){
            $form_txt = $file;
        }else if($file == "$form_id.json"){
            $form_json = $file;
        }
    };
    
    
    $content = file_get_contents("generated/$form_txt");
    $quests = explode("\n",$content);
    
    $info = file_get_contents("generated/$form_json");
    $content_json = json_decode($info, true);
    
    foreach ($content_json as $json_key => $value) {
    if ($json_key == "form_title") {
      $title = $value;
    } elseif ($json_key == "form_description") {
      $description = $value;
    } elseif ($json_key == "creator" && $value == get_email($token)) {
      $delete_button = true;
    } elseif ($json_key == "password") {
      $need_password = true;
      $password = $value;
    }
  }

  return [$title, $description, $quests, $delete_button, $need_password, $password];

}

function isJson($str){
    json_decode($str);
    return json_last_error() === JSON_ERROR_NONE;
}

function generate_work_file_json($content,$email){
    
    $json_settings = "generated/".$email."_workfile.json";
    
    if (is_file($json_settings)) {
        unlink($json_settings) or die('An error occurred while deleting the json file.');   
    }
        
    if (!file_exists($json_settings)) {
        $file = fopen($json_settings, "w") or die("Unable to open file.");
        $content["creator"] = $email;
        $content["last_edit"] = date("l jS \of F Y h:i:s A");
        fwrite($file, trim(json_encode($content)));
        fclose($file);
    }
    
    $txt_file = "generated/".$email."_workfile.txt";
    
    if (is_file($txt_file)) {
        unlink($txt_file) or die('An error occurred while deleting the json file.');   
    }
    
}
function load_work_file_txt($email){
    
    $txt_file = "generated/".$email."_workfile.txt";
    
    if(!file_exists($txt_file)){
        $file = fopen($txt_file, "w") or die("Unable to open file.");
        fclose($file);
        
        return array();
    }
    else{
        $content = file_get_contents($txt_file);
        $quests = explode("\n",$content);
        return $quests;
    }
}
function add_question($email,$question){
    $txt_file = "../generated/".$email."_workfile.txt";
    
    $content = file_get_contents($txt_file);
    if(strlen($content)>0){
        $content = $content . "\n" . $question;
    }else{
        $content = $question;
    }
    
    
    $file = fopen($txt_file, "w") or die("Unable to open file.");
    
    fwrite($file, $content);
    fclose($file);
        
}

function set_permanent($db,$email){
    
    $title = $description = "";
    $old_txt_file = "generated/".$email."_workfile.txt";
    $old_json_file = "generated/".$email."_workfile.json";
    
    $info = file_get_contents($old_json_file);
    $info_txt = file_get_contents($old_txt_file);
    $content_json = json_decode($info, true);
    
    foreach ($content_json as $json_key => $value) {
        if ($json_key == "form_title") {
            $title = $value;
        } elseif ($json_key == "form_description") {
            $description = $value;
        }
    }
    
    $form_id = add_form($db, $email, $title,  $description);
   
    $new_txt_file = "generated/".$form_id.".txt";
    $new_json_file = "generated/".$form_id.".json";
    
    unlink($old_txt_file) or die('An error occurred while deleting the old txt file.'); 
    unlink($old_json_file) or die('An error occurred while deleting the old json file.'); 
    
    $file = fopen($new_txt_file, "w") or die("Unable to open file.");
    fwrite($file, $info_txt);
    fclose($file);
    
    $file = fopen($new_json_file, "w") or die("Unable to open file.");
    fwrite($file, $info);
    fclose($file);
    
    
    
}

