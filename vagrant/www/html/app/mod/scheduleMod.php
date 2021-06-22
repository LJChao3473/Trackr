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
            <?php include("../../mustIncludes/message.php");?>
            <div>
            <div class="center-task">
                <?php
                    $userID = $_SESSION["userID"];
                    $sql = "SELECT * FROM scheduler WHERE id = '".$_GET["schedulerID"]."'";
                    $stmt = $db->getConn()->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <h5 class="old-months"><?=$result[0]["name"]?></h5>
            </div>
                <?php
                    try{
                            $sql = "SELECT * FROM schedule WHERE scheduler_id = '".$_GET["schedulerID"]."' ORDER BY time";
                            $stmt = $db->getConn()->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $i){
                ?>
                <div class="border-task">
                    <a href="../../operations/deleteEntry.php?scheduleID=<?=$i["id"]?>&page=<?=$_GET["schedulerID"]?>"><img class="icon-pictures" src="../../images/eliminar.png"></a>
                    <a class="editButton"><img class="icon-pictures" src="../../images/editar.png"></a> <br>
                    <div class="center-task">
                        <a>
                            <span class="to-do-task-name"><?=$i["name"]?></span><br>
                            <span class="to-do-task-name"><?=$i["time"]?></span><br>
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
                                <input name="editScheduleName<?=$i["id"]?>" value="<?=$i["name"]?>" class="input-name" placeholder="Folder Name" value="" required>
                                <input name="editTime<?=$i["id"]?>" value="<?=$i["time"]?>" type="time" class="input-name" required></input>
                                <br>
                                <button name="editButton<?=$i["id"]?>" class="save-transaction todo" type="submit"><i class="fas fa-check"></i></button>
                                <?php
                                    if(isset($_POST["editButton".$i["id"]])){
                                        $db->updateSchedule($_GET["schedulerID"], $_POST["id".$i["id"]], $_POST["editScheduleName".$i["id"]], $_POST["editTime".$i["id"]]);
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
                <br>
                <div class="center-task">
                    <span id="myBtn" class="add-list"><i class="fas fa-plus"></i></span>
                </div>
                
                <!-- The Modal -->
                <div id="myModal" class="modal center-task">
                  <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Add Task</h5>
                            <span class="close">&times;</span>
                            
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input name="name" class="input-name" placeholder="Task Name" required>
                                <input name="time" type="time" class="input-name" required></input><br>
                                <button name="newScheduleButton" class="save-transaction todo" type="submit" name="addTransaction"><i class="fas fa-check"></i></button>
                                <?php
                                    if(isset($_POST["newScheduleButton"])){
                                        $db->addSchedule($_GET["schedulerID"], $_POST["name"], $_POST["time"]);
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