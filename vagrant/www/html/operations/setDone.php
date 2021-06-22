<?php
    include("../mustIncludes/ddbb.php");  
    if(isset($_GET["scheduleTaskID"])){
        try{
            if($_GET["done"] == 'true'){
                $sql = "UPDATE schedule_task SET done = 0 WHERE id='".$_GET["scheduleTaskID"]."'";
            }else{
                $sql = "UPDATE schedule_task SET done = 1 WHERE id='".$_GET["scheduleTaskID"]."'";
            }
            $stmt = $db->getConn()->prepare($sql);
            $stmt->execute();
            header("Location: /main.php");
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
    
    if(isset($_GET["taskID"])){
        try{
            if($_GET["done"] == 'true'){
                $sql = "UPDATE task SET done = 0 WHERE id='".$_GET["taskID"]."'";
            }else{
                $sql = "UPDATE task SET done = 1 WHERE id='".$_GET["taskID"]."'";
            }
            echo $sql;
            $stmt = $db->getConn()->prepare($sql);
            $stmt->execute();
            header("Location: /main.php");
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
    
    if(isset($_GET["taskIDList"])){
        try{
            if($_GET["done"] == 'true'){
                $sql = "UPDATE task SET done = 0 WHERE id='".$_GET["taskIDList"]."'";
            }else{
                $sql = "UPDATE task SET done = 1 WHERE id='".$_GET["taskIDList"]."'";
            }
            echo $sql;
            $stmt = $db->getConn()->prepare($sql);
            $stmt->execute();
            header("Location: /app/taskList.php?folderID=".$_GET["folderID"]);
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
    
    if(isset($_GET["challengeID"])){
        try{
            if($_GET["done"] == 'true'){
                $sql = "UPDATE daily_challenge SET done = 0 WHERE id='".$_GET["challengeID"]."'";
            }else{
                $sql = "UPDATE daily_challenge SET done = 1 WHERE id='".$_GET["challengeID"]."'";
            }
            $stmt = $db->getConn()->prepare($sql);
            $stmt->execute();
            header("Location: /main.php");
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>