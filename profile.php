<?php
session_start();
  
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: logout.php");
    exit;
}
 
require_once "config.php";

include "templates/profile.html";

?>