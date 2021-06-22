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
            <div>
                <h2>Task Lists</h2>
                <?php
                    try{
                    $todoID = $_GET["folderID"];
                    $sqlTask = "SELECT * FROM task WHERE folder_id='$todoID' ORDER BY done";
                    $stmt = $db->getConn()->prepare($sqlTask);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $i){
                ?>
                <div class="border-task">
                    <a href="../operations/deleteEntry.php?todoID=<?=$todoID?>&taskID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/eliminar.png"></a>
                    <a href="mod/taskMod.php/?folderID=<?=$todoID?>&taskID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/editar.png"></a> <br>
                    <a href="../operations/setDone.php?taskIDList=<?=$i["id"]?>&done=<?=$i["done"] ? "true":"false"?>&folderID=<?=$todoID?>" class="task-button"><i class="fas fa-<?=$i["done"] == 1 ? "times-circle red-times":"check-circle green-check"?>"></i></a>
                    <!--check-circle green-check-->
                    <div class="center-task">
                        <span style="<?=$i["done"] == 1 ? "text-decoration: line-through;":""?>" class="to-do-task-name"><?=$i["name"]?></span> 
                        <?php
                            $contact = "SELECT count(*) AS count, contact.fname as name FROM contact, contact_task, task WHERE contact_task.contact_id = contact.id AND contact_task.task_id = task.id AND task.id = '".$i["id"]."'";
                            $stmtContact = $db->getConn()->prepare($contact);
                            $stmtContact->execute();
                            $resultContact = $stmtContact->fetchAll(PDO::FETCH_ASSOC);
                            if ($stmtContact->rowCount() > 0) {
                                if($resultContact[0]["count"] == 1){
                                    echo "<br><span class='to-do-remaining-task'>-with ".$resultContact[0]["name"]."</span>";
                                }else if($resultContact[0]["count"] > 1){
                                    echo "<br><span class='to-do-remaining-task'>-with ".$resultContact[0]["name"]." and ".($resultContact[0]["count"]-1)." more</span>";
                                }
                            }else{
                                echo "<br><br>";
                            }
                        ?>
                    </div>
                </div>
                <?php
                            }
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }  
                ?>
                
                
                <?php
                    try{
                    $todoID = $_GET["folderID"];
                    $sqlTask = "SELECT * FROM challenge WHERE folder_id='$todoID'";
                    $stmt = $db->getConn()->prepare($sqlTask);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Challenge Lists</h2>";
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $i){
                ?>
                <div class="border-task">
                    <a href="../operations/deleteEntry.php?todoID=<?=$todoID?>&challengeID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/eliminar.png"></a>
                    <a href="mod/taskMod.php/?folderID=<?=$todoID?>&challengeID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/editar.png"></a> <br>
                    <div class="center-task">
                        <span class="to-do-task-name"><?=$i["name"]?></span> 
                        
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
                    <a href="mod/taskMod.php/?folderID=<?=$todoID?>" ><span class="add-list"><i class="fas fa-plus"></i></span></a>
                </div>
            </div>
        </div>
        <?php include("../mustIncludes/message.php"); ?>
        
    </body>
</html>
