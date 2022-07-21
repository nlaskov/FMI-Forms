<?php
function check_email($db,$email){
    
    $sql_stat = "SELECT email FROM users";

    $stmt = $db->query($sql_stat);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    
    foreach($result as $value){
        foreach($value as $val){
            if($email == $val){
                return FALSE;
            }
        }
    }
    
    return TRUE;
}

function register_user($db, $param_email, $param_password, $param_fk, $param_name, $email, $password)
{
  $sql = "INSERT INTO users (email, password, fk, name) VALUES (?, ?, ?, ?)";

  if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param("ssds", $param_email, $param_password, $param_fk, $param_name);

    $param_email = $email;
    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
    $param_fk = trim($_POST["fn"]);
    $param_name = trim($_POST["name"]);

    if ($stmt->execute()) {
      header("location: login");
    } else {
      echo "Oops! Something went wrong. Please try again later.";
      echo $stmt->error;
    }
    $stmt->close();
  }
}

function login_user($db, $email){
    $sql_stat = "SELECT password FROM users WHERE email = '" . $email . "'";
    $stmt = $db->query($sql_stat);
    
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    return $result;
}

function add_form($db, $email, $title, $decription){
    
    $sql_stat = "INSERT INTO forms(title,description,created_by) VALUES(?, ?, ?)";
    
    if ($stmt = $db->prepare($sql_stat)) {
        
        $stmt->bind_param("sss", $title, $decription, $email);
        $stmt->execute();
            
        $stmt->close();
    }
    $id = (int)mysqli_insert_id($db);
    
    return $id;
}

function add_shared_form($db,$email,$form_id){
    $sql_stat = "INSERT INTO shared(email,form_id) VALUES(?, ?)";
    
    if ($stmt = $db->prepare($sql_stat)) {
        
        $stmt->bind_param("si", $email, $form_id,);
        $stmt->execute();
            
        $stmt->close();
    }
    $id = (int)mysqli_insert_id($db);
    
    return $id;
}

function get_forms($db, $email){
    $sql_stat = "SELECT id FROM forms where created_by = '" . $email . "'";
    $stmt = $db->query($sql_stat);
    
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    
    $sql_stat = "SELECT form_id FROM shared where email = '" . $email . "'";
    
    $stmt = $db->query($sql_stat);
    $result_shared = $stmt->fetch_all(MYSQLI_ASSOC);
    return array_merge($result, $result_shared);
}

function check_form($db,$id){
    $sql_stat = "SELECT id FROM forms";
    $stmt = $db->query($sql_stat);
    
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    
    foreach($result as $value){
        foreach($value as $val){
            if($id == $val){
                return TRUE;
            }
        }
    }
    
    return FALSE;
}

function delete_form($db,$id){
    $sql_stat = "DELETE FROM shared WHERE form_id = '" . $id . "'";
    
    $db->query($sql_stat);
    
    
    $sql_stat = "DELETE FROM forms WHERE id = '" . $id . "'";
    
    $stmt = $db->query($sql_stat);
    
    
    
}

function delete_shared_form($db, $id, $email){
    $sql_stat = "DELETE FROM shared WHERE form_id = '$id' and email = '$email'";
    
    $stmt = $db->query($sql_stat);
    
}
?>
