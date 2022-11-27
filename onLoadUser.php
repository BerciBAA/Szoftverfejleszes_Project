<?php
    include_once "config.php";
    session_start();
    $sql = mysqli_query($link,"SELECT * FROM users");
    $output = "";
    if(mysqli_num_rows($sql) == 0){
        $output = "Nincs elérhető felhasználó.";
    }
    elseif(mysqli_num_rows($sql) > 0){
        while($row = mysqli_fetch_assoc($sql)){
            $output .=  '<a href="chat.php?user_id='.$row['id'].'">
                        <div class="content">
                        <img src="img/test_mage.jpg" alt="">
                        <div class="details">
                        <span>'. $row['username'] .'</span>
                        <p>TESZT ÜZENET</p>
                        </div>
                        </div>
                        <div class="statusDot">
                        <i class="fa fa-circle"></i>
                        </div>
                        </a>';
        }
        
    }
    echo $output;

?>
