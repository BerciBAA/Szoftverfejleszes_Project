<?php
    include_once "config.php";
    session_start();
    $sql = mysqli_query($link,"SELECT * FROM users where username != '{$_SESSION['username']}' ORDER BY status");
    $output = "";
    $lastMsg = "";
    if(mysqli_num_rows($sql) == 0){
        $output = "Nincs elérhető felhasználó.";
    }
    elseif(mysqli_num_rows($sql) > 0){
        while($row = mysqli_fetch_assoc($sql)){
            
            if($row['status'] =='Aktív'){
                
                $output .=  '<a href="chat.php?user_id='.$row['id'].'">
                        <div class="content">
                        <img src="img/test_mage.jpg" alt="">
                        <div class="details">
                        <span>'. $row['username'] .'</span>
                        <p>'.$lastMsg.'</p>
                        </div>
                        </div>
                        <div class="statusDot">
                        <i class="fa fa-circle"></i>
                        </div>
                        </a>';
            }else{
                $output .=  '<a href="chat.php?user_id='.$row['id'].'">
                        <div class="content">
                        <img src="img/test_mage.jpg" alt="">
                        <div class="details">
                        <span>'.$row['username'].'</span>
                        <p>'.$lastMsg.'</p>
                        </div>
                        </div>
                        <div class="statusDotOffile">
                        <i class="fa fa-circle"></i>
                        </div>
                        </a>';
            }
            
        }
        
    }
    echo $output;
?>
