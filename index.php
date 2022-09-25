<?php

require_once "config.php";

$errors = [];
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $errors[]  = "username_empty_err";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $errors[]  = "username_content_err";;
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            $stmt->bind_param("s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $errors[] = "username_taken_err";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                $errors[] = "db_error";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $errors[]  = "password_empty_err"; 
    } elseif(strlen(trim($_POST["password"])) < 6){
        $errors[]  = "password_length_err";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $errors[]  = "confirm_empty_err";    
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $errors[]  = "confirm_match_err";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = trim($_POST["email"]);
            
            if(!mysqli_stmt_execute($stmt)){
                $errors[] = "db_error";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);

    echo json_encode($errors);
}
else{
    include "templates/index.html";
}
?>