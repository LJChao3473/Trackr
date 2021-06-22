<?php
    include("../../mustIncludes/ddbb.php");
    include("../../mustIncludes/header.php");
?>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn navbar-btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                </div>
            </nav>
            <?php include("../../mustIncludes/message.php"); ?>
            <?php 
                $sql = "SELECT * FROM to_do_folder WHERE id = '".$_GET["folderID"]."'";
                $stmt = $db->getConn()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            ?>
            <h2><?=$result[0]["name"];?></h2>
            <div class="center-form todo">
                <form method="POST">
                    <?php
                        $folderID=$_GET["folderID"];
                        if(isset($_GET["challengeID"])){
                            $challengeID = $_GET["challengeID"];
                            $sql = "SELECT * FROM challenge WHERE id = '".$_GET["challengeID"]."'";
                            $stmt = $db->getConn()->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $name = $result[0]["name"];
                            $description = $result[0]["description"];
                        }else if(isset($_GET["taskID"])){
                            $challengeID = $_GET["taskID"];
                            $sql = "SELECT * FROM task WHERE id = '".$_GET["taskID"]."'";
                            $stmt = $db->getConn()->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $name = $result[0]["name"];
                            $description = $result[0]["description"];
                            $date = $result[0]["date"];
                            $time = $result[0]["time"];
                            $important2 = $result[0]["important"];
                            $done = $result[0]["done"];
                        }else{
                            $name = "";
                            $description = "";
                            $date = "";
                            $time = "";
                            $important2 = "";
                        }
                    ?>
                    <select id="type" name="type" class="dropdown-financial todo" <?=isset($_GET["taskID"])||isset($_GET["challengeID"]) ? "disabled":""?>>
                        <option value="task" selected>Task</option>
                        <option id="challenge" value="challenge">Challenge</option>
                    </select> 
                    <label id="important" class="container-checkbox">
                        <input name="important" type="checkbox" <?=$important2 == 1 ? "checked":""?>>
                        <span class="checkmark-task todo"></span>
                     </label>
                    <br>
                    <input name="name" class="task-name" type="text" value="<?=$name?>" placeholder="Name" required></input>
                    <br>
                    <input name="date" id="date" class="task-date" type="date" value="<?=$date?>" placeholder="Date"></input>
                    <input name="time" id="time" class="task-date" type="time" value="<?=$time?>" placeholder="Time" required></input>
                    <br>
                    <div id="contactsDiv">
                        <div style="display: none">
                            <select name="contact[]" class="dropdown-financial todo">
                                <option value="" disabled selected>Contact</option>
                                <?php
                                    try{
                                        $userID = $_SESSION["userID"];
                                        $sqlTodo = "SELECT * FROM contact WHERE user_id = '$userID'";
                                        $stmt = $db->getConn()->prepare($sqlTodo);
                                        $stmt->execute();
                                        if ($stmt->rowCount() > 0) {
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $i){
                                ?>
                                <option value="<?=$i["id"]?>"><?=$i["fname"]." ".$i["lname"]?></option>
                                <?php
                                            }
                                        }
                                    } catch(PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }   
                                ?>
                            </select>
                            <button type="button" name="remove" class="cancel-contact todo" ><i class="fas fa-times" style="pointer-events: none;"></i></button>
                        </div>
                        <?php
                            if(isset($_GET["taskID"])){
                                try{
                                    $sqlTask = "SELECT * FROM contact_task WHERE task_id = '".$_GET["taskID"]."'";
                                    $stmtTask = $db->getConn()->prepare($sqlTask);
                                    $stmtTask->execute();
                                    if ($stmtTask->rowCount() > 0) {
                                        $resultTask = $stmtTask->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($resultTask as $task){
                        ?>
                        <div>
                            <?php
                                try{
                                    $userID = $_SESSION["userID"];
                                    $sqlTodo = "SELECT * FROM contact WHERE user_id = '$userID'";
                                    $stmt = $db->getConn()->prepare($sqlTodo);
                                    $stmt->execute();
                                    if ($stmt->rowCount() > 0) {
                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select name="contact[]" class="dropdown-financial todo">
                                <option value="" disabled>Contact</option>
                                <?php
                                            foreach ($result as $i){
                                ?>
                                <option value="<?=$i["id"]?>" <?=$task["contact_id"]==$i["id"] ? "selected":""?>><?=$i["fname"]." ".$i["lname"]?></option>
                                <?php
                                            }
                                        }
                                    } catch(PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }   
                                ?>
                            </select>
                            <button type="button" name="remove" class="cancel-contact todo" ><i class="fas fa-times" style="pointer-events: none;"></i></button>
                        </div>
                        <?php
                                        }
                                    }
                                } catch(PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }   
                            }
                        ?>
                        
                    </div>
                    <button type="button" id="addContact" class="button-search todo"><i class="fas fa-user-plus"></i> Add Contact</button>
                    <br>
                    <textarea placeholder="Description" name="description" maxlength="200" class="form-control"><?=$description?></textarea>
                    <br>
                    <button class="cancel-contact todo-reset" type="reset"><i class="fas fa-times"></i></button>
                    <button class="save-contact todo-save" type="submit" name="submit"><i class="fas fa-check"></i></button>
                </form>
                <?php
                    if(isset($_POST["submit"])){
                        if(isset($_GET["challengeID"])){
                            $db->updateChallenge($_GET["challengeID"], $_GET["folderID"], $_POST["name"], $_POST["description"]);
                        }else if(isset($_GET["taskID"])){
                            if(isset($_POST["important"])){
                                    $important = 1;
                                }else{
                                    $important = 0;
                                }
                                $db->updateTask($_GET["taskID"], $_POST["name"], $_POST["description"], $_POST["date"], $_POST["time"], $important);
                                $db->deleteContactTask($_GET["taskID"]);
                                if(isset($_POST["contact"])){
                                    for($i = 0; $i < count($_POST["contact"]); $i++){
                                        if($_POST["contact"][$i] != 0){
                                            $db->addContactTask($_GET["taskID"], $_POST["contact"][$i]);
                                        }
                                    }
                                }
                                header("Location: /app/tasklist.php?folderID=".$_GET["folderID"]."");
                        }else{
                            if($_POST["type"] == "task"){
                                if(isset($_POST["important"])){
                                    $important = 1;
                                }else{
                                    $important = 0;
                                }
                                $db->addTask($_GET["folderID"], $_POST["name"], $_POST["description"], $_POST["date"], $_POST["time"], $important);
                                $sqlTodo = "SELECT last_insert_id() as id";
                                $stmt = $db->getConn()->prepare($sqlTodo);
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $taskId = $result[0]["id"];
                                if(isset($_POST["contact"])){
                                    for($i = 0; $i < count($_POST["contact"]); $i++){
                                        if($_POST["contact"][$i] != 0){
                                            $db->addContactTask($taskId, $_POST["contact"][$i]);
                                        }
                                    }
                                }
                                header("Location: /app/tasklist.php?folderID=".$_GET["folderID"]."");
                            }else{
                                $db->addChallenge($_SESSION["userID"], $_GET["folderID"], $_POST["name"], $_POST["description"]);
                            }
                        }
                    }
                ?> 
            </div>
        </div>
    </body>
    <script src="../../../js/taskAddContact.js" type="text/javascript"></script>
    <script type="text/javascript">
        window.onload = function() {
            <?php
                if(isset($_GET["challengeID"])){
                    echo "typeChallenge();document.getElementById('challenge').selected = 'true';";
                }else{
                    echo "typeTask();";
                }
            ?>
        }
    </script>
</html>
