<?php
    include("../mustIncludes/ddbb.php");
    //Contact
    if(isset($_GET["contactID"])){
        try {
          $sql = "DELETE FROM contact WHERE id='".$_GET["contactID"]."'";
          $db->getConn()->exec($sql);
          $_SESSION["message"] = "A contact have been deleted";
          $_SESSION["alert"] = "success";
          header("Location: /app/contact.php");
        } catch(PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    if(isset($_GET["todoID"]) && isset($_GET["taskID"])){
        try {
          $sql = "DELETE FROM task WHERE id='".$_GET["taskID"]."'";
          $db->getConn()->exec($sql);
          $_SESSION["message"] = "A task have been deleted";
          $_SESSION["alert"] = "success";
          header("Location: /app/tasklist.php?folderID=".$_GET["todoID"]."");
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    if(isset($_GET["todoID"]) && isset($_GET["challengeID"])){
        try {
            $sql = "DELETE FROM challenge WHERE id='".$_GET["challengeID"]."'";
            $db->getConn()->exec($sql);
            
            $sql = "DELETE FROM daily_challenge WHERE challenge_id='".$_GET["challengeID"]."'";
            $db->getConn()->exec($sql);
            $_SESSION["message"] = "A task challenge been deleted";
            $_SESSION["alert"] = "success";
            header("Location: /app/tasklist.php?folderID=".$_GET["todoID"]."");
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    if(isset($_GET["folderID"])){
        try {
            //DELETE all tasks
            $sqlFolder = "DELETE FROM task WHERE folder_id='".$_GET["folderID"]."'";
            $db->getConn()->exec($sqlFolder);        
            
            $sqlFolder = "DELETE FROM to_do_folder WHERE id='".$_GET["folderID"]."'";
            $db->getConn()->exec($sqlFolder);
            $_SESSION["message"] = "A folder have been deleted";
            $_SESSION["alert"] = "success";
            header("Location: /app/todolist.php");
        } catch(PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    if(isset($_GET["schedulerID"])){
        try {
            $sql = "DELETE FROM scheduler WHERE id='".$_GET["schedulerID"]."'";
            $db->getConn()->exec($sql);
            $sql = "DELETE FROM schedule WHERE scheduler_id='".$_GET["schedulerID"]."'";
            $db->getConn()->exec($sql);
            $_SESSION["message"] = "A scheduler have been deleted";
            $_SESSION["alert"] = "success";
            header("Location: /app/mod/schedulerMod.php?day=".$_GET["day"]);
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    if(isset($_GET["scheduleID"])){
        try {
            $sql = "DELETE FROM schedule WHERE id='".$_GET["scheduleID"]."'";
            $db->getConn()->exec($sql);
            $_SESSION["message"] = "A scheduler have been deleted";
            $_SESSION["alert"] = "success";
            header("Location: /app/mod/scheduleMod.php?schedulerID=".$_GET["page"]);
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
?>

