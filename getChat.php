<?php
    session_start();
    if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true){
        include_once "config.php";
        $outgoindId = mysqli_real_escape_string($link,$_POST['outgoing_id']);
        $incomingId = mysqli_real_escape_string($link,$_POST['incoming_id']);

        $output = "";

        $sql = "SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoindId} AND incoming_msg_id = {$incomingId})
        OR (outgoing_msg_id = {$incomingId} AND incoming_msg_id = {$outgoindId}) ORDER BY msg_id ASC";

        $query = mysqli_query($link, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] == $outgoindId){
                    $output .= '<div class="chat outgoing">
                    <div class="details">
                    <p>'.$row['msg'].'</p>
                    </div>
                    </div>';
                }
                else{
                    $output .= '<div class="chat incoming">
                    <img src="img/test_mage.jpg" alt="">
                    <div class="details">
                    <p>'.$row['msg'].'</p>
                    </div>
                    </div>';
                }
            }
            
        }
        echo $output;
    }
    else
    {
        header("location: login.php");
        exit;
    }





?>