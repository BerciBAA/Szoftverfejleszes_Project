<?php
session_start();
  
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}
 
require_once "config.php";

$params = [];
$params["action"] = isset($_POST["action"]) ? $_POST["action"] : "";
if(isset($_POST["form"])){
    $params["username"] = "";
    $params["birthdate"] = "1000-01-01";
    $params["microphone"] = 0;
    $params["gender"] = 0;
    $params["description"] = "";
    foreach($_POST["form"] as $input){
        if($input["name"] == "microphone"){
            if($input["value"] == "on"){
                $params["microphone"] = 1;
            }
            else{
                $params["microphone"] = 2;
            }
        }
        else{
            $params[$input["name"]] = $input["value"];
        }
    }
}


if($params["action"] == "show"){
    $sql = "SELECT * FROM users WHERE username = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("s", $param_username);
        
        $param_username = $_SESSION["username"];
        
        if(mysqli_stmt_execute($stmt)){            
            echo(json_encode(mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))));
        } else{
            $errors[] = "db_error";
        }
        mysqli_stmt_close($stmt);
    }
}
elseif($params["action"] == "set"){ 
    $sql = "UPDATE `users` SET `username` = ?, `birthdate` = ?, `microphone` = ?, `gender` = ?, `description` = ?  WHERE username = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("ssiiss", $params["username"], $params["birthdate"], $params["microphone"], $params["gender"], $params["description"], $param_username);

        $param_username = $_SESSION["username"];
        
        if(!mysqli_stmt_execute($stmt)){
            $errors[] = "db_error";
        }
        mysqli_stmt_close($stmt);
    }
}
else{
    include "templates/profile.html";
}


?>