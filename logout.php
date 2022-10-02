<?php
    session_start();
    require_once "config.php";
    $_SESSION["loggedin"] = false;
    header("location: login.php")
?>