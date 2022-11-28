<?php
    session_start();
    require_once "config.php";
    $sql = mysqli_query($link,"UPDATE users SET status = 'Nem aktív' where username = '{$_SESSION["username"]}'"); 
    $_SESSION["loggedin"] = false;
     
    header("location: login.php")
?>