<?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
        header("location: login.php");
        exit;
    }
    $user_id = mysqli_real_escape_string($link, $_GET['user_id']);
    $sql = mysqli_query($link, "SELECT * FROM users where id = '{$user_id}'");
    if(mysqli_num_rows($sql) > 0){
        $otherMan = mysqli_fetch_assoc($sql);
    }
    $sql = mysqli_query($link, "SELECT * FROM users where username = '{$_SESSION['username']}'");
    if(mysqli_num_rows($sql) > 0){
        $myMan = mysqli_fetch_assoc($sql);
    }
    include "templates/chat.html";

?>