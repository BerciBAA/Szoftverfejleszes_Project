<?php
session_start();
 
require_once "config.php";

$params = [];
$params["action"] = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "";
$params["game_id"] = isset($_REQUEST["game_id"]) ? $_REQUEST["game_id"] : "";
$params["title"] = isset($_REQUEST["title"]) ? $_REQUEST["title"] : "";
if(isset($_REQUEST["form"])){
    $params["screen_name"] = "";
    $params["rank"] = "";
    foreach($_REQUEST["form"] as $input){
        $params[$input["name"]] = $input["value"];
    }
}

if($params["action"] == "getUnsetGames"){
    $sql = "SELECT g.id, g.name FROM games g WHERE g.id NOT IN (SELECT gameid FROM user_games WHERE userid = ?);";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("s", $param_id);
        
        $param_id = $_SESSION["id"];
        
        if(mysqli_stmt_execute($stmt)){
            $rows = [];
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            echo(json_encode($rows));
        } else{
            $errors[] = "db_error";
        }
        mysqli_stmt_close($stmt);
    }
}
elseif($params["action"] == "setGame"){ 
    $sql = "INSERT INTO user_games (userid, gameid, screenname, rank) VALUES (?,?,?,?)";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("iiss", $param_id, $params["game_id"], $params["screen_name"], $params["rank"]);

        $param_id = $_SESSION["id"];
        
        if(!mysqli_stmt_execute($stmt)){
            $errors[] = "db_error";
            
        }
        mysqli_stmt_close($stmt);
    }
}
elseif($params["action"] == "getGames"){
    $sql = "SELECT g.id as gameId, g.name as gameName, ug.screenname as screenName, ug.rank as rank FROM games g INNER JOIN user_games ug ON g.id = ug.gameid WHERE ug.userid = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("i", $param_id);
        
        $param_id = $_SESSION["id"];
        
        if(mysqli_stmt_execute($stmt)){
            $rows = [];
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            echo(json_encode($rows));
        } else{
            $errors[] = "db_error";
        }
        mysqli_stmt_close($stmt);
    }
}
elseif($params["action"] == "postVideo"){
    $target_dir = "uploads/";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($_FILES["video"]["name"],PATHINFO_EXTENSION));
    $target_file = $target_dir.$params["title"]."_".$_SESSION["id"]."_".$params["game_id"].".".$fileType;
    if (!file_exists("upload/" . $_FILES["video"]["name"])){
        move_uploaded_file($_FILES["video"]["tmp_name"],$target_file);
    }
    else{
        exit;
    }
    $sql = "INSERT INTO videos (userid, gameid, filename,extension) VALUES (?,?,?,?)";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("iiss", $param_id, $params["game_id"], $params["title"],$fileType);

        $param_id = $_SESSION["id"];
        
        if(!mysqli_stmt_execute($stmt)){
            $errors[] = "db_error";
            
        }
        mysqli_stmt_close($stmt);
    }
}
elseif($params["action"] == "getVideos"){
    $sql = "SELECT * FROM videos WHERE userid = ? AND gameid = ?;";
        
    if($stmt = mysqli_prepare($link, $sql)){
        $stmt->bind_param("ii", $param_id,$params["game_id"]);
        
        $param_id = $_SESSION["id"];
        
        if(mysqli_stmt_execute($stmt)){
            $rows = [];
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
                $video = [];
                $video["title"] = $row["filename"];
                $video["filename"] = "uploads/".$row["filename"]."_".$row["userid"]."_".$row["gameid"].".".$row["extension"];
                $rows[] = $video;
            }
            echo(json_encode($rows));
        } else{
            $errors[] = "db_error";
        }
        mysqli_stmt_close($stmt);
    }
}
else{
    echo $params["action"];
}


?>