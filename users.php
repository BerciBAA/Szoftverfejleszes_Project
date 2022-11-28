<?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
        header("location: login.php");
        exit;
    }
    $sql = mysqli_query($link, "SELECT * FROM users where username = '{$_SESSION['username']}'");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }
    include "templates/users.html";
   
?>      