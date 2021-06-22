<?php
    include("../mustIncludes/ddbb.php");
    include("../mustIncludes/header.php");
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
            <?php include("../mustIncludes/message.php"); ?>
            <div>
                <h2>To-do Lists</h2>
                <?php
                    try{
                        $userID = $_SESSION["userID"];
                        $sqlTodo = "SELECT * FROM to_do_folder WHERE user_id = '$userID'";
                        $stmt = $db->getConn()->prepare($sqlTodo);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0) {
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $i){
                                $sqlTasks = "SELECT COUNT(*) as 'tasks' FROM task WHERE done = '0'AND folder_id = '".$i["id"]."'";
                                $stmtTask = $db->getConn()->prepare($sqlTasks);
                                $stmtTask->execute();
                                $resultTask = $stmtTask->fetchAll(PDO::FETCH_ASSOC);
                                
                ?>
                <!--Show the folders-->
                <div class="border-task">
                    
                        <a href="../operations/deleteEntry.php?folderID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/eliminar.png"></a>
                        <a class="editButton"><img class="icon-pictures" src="../images/editar.png"></a> <br>
                        <div class="center-task">
                        <a href='tasklist.php?folderID=<?=$i["id"]?>' >
                            <span class="to-do-task-name"><?=$i["name"]?></span> <br>
                            <span class="to-do-remaining-task"><?=$resultTask[0]["tasks"]?> task(s) remaining</span>
                        </a>
                        </div>
                    
                </div>
                <!--edit Modals-->
                <div class="modal center-task myModalEdit">
                  <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Modify Folder</h5>
                            <span class="close">&times;</span>
                            
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input type="hidden" name="id<?=$i["id"]?>" value="<?=$i["id"]?>">
                                <input name="editFolderName<?=$i["id"]?>" class="input-name" placeholder="Folder Name" value="<?=$i["name"]?>" required>
                                <button name="editFolderButton<?=$i["id"]?>" class="save-transaction todo" type="submit" name="addTransaction"><i class="fas fa-check"></i></button>
                            </form>
                        </div>
                        <?php
                            if(isset($_POST["editFolderButton".$i["id"]])){
                                $db->updateFolder($_POST["id".$i["id"]], $_POST["editFolderName".$i["id"]]);
                            }
                        ?>
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
                            <h5>Add Folder</h5>
                            <span class="close">&times;</span>
                            
                        </div>
                        <div class="modal-body">
                            <form action="./todolist.php" method="POST">
                                <input name="newFolderName" class="input-name" placeholder="Folder Name" required>
                                <button name="newFolderButton" class="save-transaction todo" type="submit" name="addTransaction"><i class="fas fa-check"></i></button>
                            </form>
                        </div>
                        <?php
                            if(isset($_POST["newFolderButton"])){
                                $db->addFolder($_SESSION["userID"], $_POST["newFolderName"]);
                            }
                        ?>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/modal.js" type="text/javascript"></script>
    </body>
</html>