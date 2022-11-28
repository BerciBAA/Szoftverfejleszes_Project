<?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
        header("location: login.php");
        exit;
    }
    
    include "templates/main.html";
?>