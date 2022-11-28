<?php
    session_start();
    if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true){
        include_once "config.php";
        $outgoindId = mysqli_real_escape_string($link,$_POST['outgoing_id']);
        $incomingId = mysqli_real_escape_string($link,$_POST['incoming_id']);
        $message = mysqli_real_escape_string($link,$_POST['message']);

        if(!empty($message)){
            $sql = mysqli_query($link, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id,msg)
             VALUES ({$incomingId}, {$outgoindId}, '{$message}')") or die();
        }
    }
    else
    {
        header("location: login.php");
        exit;
    }

?>