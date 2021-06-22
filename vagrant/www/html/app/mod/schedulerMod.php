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
                if(!isset($_SESSION["day"])){
                    $_SESSION["day"] = date('w', strtotime("now"));
                }
                $days = [
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    0 => 'Sunday'
                  ];
                
                if(isset($_GET["increase"])){
                    $_SESSION["day"]++;
                    if($_SESSION["day"] > 6){
                        $_SESSION["day"] = 0;
                    }
                    header("Location: ./schedulerMod.php");
                }
                if(isset($_GET["decrease"])){
                    $_SESSION["day"]--;
                    if($_SESSION["day"] < 0){
                        $_SESSION["day"] = 6;
                    }
                    header("Location: ./schedulerMod.php");
                }
            ?>
            <div class="center-task">
                <a href="./schedulerMod.php?decrease=true" class="arrow left"></a>
                <a href="./schedulerMod.php?increase=true" class="arrow right"></a>
                <h5 class="old-months"><?=$days[$_SESSION["day"]]?></h5>
            </div>
            <div>
                <?php
                    try{
                            $userID = $_SESSION["userID"];
                            $sqlTodo = "SELECT * FROM scheduler WHERE user_id = '$userID' AND day = '".$days[$_SESSION["day"]]."' ORDER BY initial_time, end_time";
                            $stmt = $db->getConn()->prepare($sqlTodo);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $i){
                ?>
                <div class="border-task">
                    <a href="../../operations/deleteEntry.php?schedulerID=<?=$i["id"]?>&day=<?=$days[$_SESSION["day"]]?>"><img class="icon-pictures" src="../../images/eliminar.png"></a>
                    <a class="editButton"><img class="icon-pictures" src="../../images/editar.png"></a> <br>
                    <div class="center-task">
                        <a href="scheduleMod.php?schedulerID=<?=$i["id"]?>">
                            <span class="to-do-task-name"><?=$i["name"]?></span><br>
                            <span class="to-do-task-name"><?=$i["initial_time"]?></span><br>
                            <span class="to-do-task-name"><?=$i["end_time"]?></span><br>
                        </a>
                    </div>
                </div>
                <!--edit Modals-->
                <div class="modal center-task myModalEdit">
                  <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Modify Scheduler</h5>
                            <span class="close">&times;</span>
                            
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input type="hidden" name="id<?=$i["id"]?>" value="<?=$i["id"]?>">
                                <input name="editFolderName<?=$i["id"]?>" value="<?=$i["name"]?>" class="input-name" placeholder="Folder Name" value="" required>
                                <input name="editiTime<?=$i["id"]?>" value="<?=$i["initial_time"]?>" type="time" class="input-name" required></input>
                                <input name="editeTime<?=$i["id"]?>" value="<?=$i["end_time"]?>" type="time" class="input-name" required></input>
                                <select class="dropdown-sched" name="editDay<?=$i["id"]?>" class="input-name">
                                    <option value="Monday" <?=$i["day"] == "monday" ? "selected":""?>>Monday</option>
                                    <option value="Tuesday" <?=$i["day"] == "tuesday" ? "selected":""?>>Tuesday</option>
                                    <option value="Wednesday" <?=$i["day"] == "wednesday" ? "selected":""?>>Wednesday</option>
                                    <option value="Thursday" <?=$i["day"] == "thursday" ? "selected":""?>>Thursday</option>
                                    <option value="Friday" <?=$i["day"] == "friday" ? "selected":""?>>Friday</option>
                                    <option value="Saturday" <?=$i["day"] == "saturday" ? "selected":""?>>Saturday</option>
                                    <option value="Sunday" <?=$i["day"] == "sunday" ? "selected":""?>>Sunday</option>
                                </select>
                                <br>
                                <button name="editFolderButton<?=$i["id"]?>" class="save-transaction todo" type="submit"><i class="fas fa-check"></i></button>
                                <?php
                                    if(isset($_POST["editFolderButton".$i["id"]])){
                                        $db->updateScheduler($_POST["id".$i["id"]], $_POST["editDay".$i["id"]], $_POST["editFolderName".$i["id"]], $_POST["editiTime".$i["id"]], $_POST["editeTime".$i["id"]], $days[$_SESSION["day"]]);
                                    }
                                ?>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
                <?php
                            }
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }    
                ?>
                
                <div class="center-task">
                    <span id="myBtn" class="add-list"><i class="fas fa-plus"></i></span>
                </div>
                
                <!-- The Modal -->
                <div id="myModal" class="modal center-task">
                  <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Add Scheduler</h5>
                            <span class="close">&times;</span>
                            
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input name="name" class="input-name" placeholder="Folder Name" required>
                                <input name="iTime" type="time" class="input-name" required></input>
                                <input name="eTime" type="time" class="input-name" required></input><br>
                                <button name="newFolderButton" class="save-transaction todo" type="submit" name="addTransaction"><i class="fas fa-check"></i></button>
                                <?php
                                    if(isset($_POST["newFolderButton"])){
                                        $db->addScheduler($_SESSION["userID"], $days[$_SESSION["day"]], $_POST["name"], $_POST["iTime"], $_POST["eTime"]);
                                    }
                                ?>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="../../js/modal.js" type="text/javascript"></script>
</html>