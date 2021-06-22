<?php
    include("mustIncludes/ddbb.php");
    include("mustIncludes/header.php");
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
            <?php include("mustIncludes/message.php");
            ?>
            <h2>Today's Schedule</h2>
            <div class="container-fluid">
                <?php
                    $days = [
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        0 => 'Sunday'
                      ];
                    try{
                        $today = date('w', strtotime("now"));
                        $schedulerSQL = "SELECT * FROM scheduler WHERE user_id = '$userID' AND day = '".$days[$today]."' order by initial_time, end_time";
                        $stmtScheduler = $db->getConn()->prepare($schedulerSQL);
                        $stmtScheduler->execute();
                        if ($stmtScheduler->rowCount() > 0) {
                            $result = $stmtScheduler->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $i){
                ?>
                                <div>
                                    <h5><?=$i["initial_time"]." - ".$i["end_time"]." > ".$i["name"]?></h5>
                                    <table class="table">
                                        <tbody>
                                            <?php
                                                $today = date('w', strtotime("now"));
                                                $scheduleSQL = "SELECT *, schedule_task.id AS taskID, schedule_task.done AS done FROM schedule, schedule_task WHERE schedule_task.schedule_id = schedule.id AND scheduler_id =  '".$i["id"]."' AND schedule_task.date = CURDATE() ORDER BY schedule_task.date";
                                                $stmtSchedule = $db->getConn()->prepare($scheduleSQL);
                                                $stmtSchedule->execute();
                                                if ($stmtSchedule->rowCount() > 0) {
                                                    $resultSchedule = $stmtSchedule->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($resultSchedule as $y){
                                            ?>
                                                <tr style="<?=$y["done"] == 1 ? "text-decoration: line-through;":""?>">
                                                    <td>
                                                        <a href="operations/setDone.php?scheduleTaskID=<?=$y["taskID"]?>&done=<?=$y["done"] == 1 ? "true":"false"?>"><i class="fas fa-<?=$y["done"] == 1 ? "times-circle red-times":"check-circle green-check"?>"></i></a>
                                                    </td>
                                                    <td><?=$y["name"]?></td>
                                                    <td><?= date('H:i', strtotime($y["time"]));?></td>
                                                </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                <?php
                            }
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }   
                ?>
                <!-- END TASK -->
                
                
                <!-- TO DO LIST -->
                <div>
                    <h5>To-Do</h5>
                    <table class="table">
                        <tbody>
                        <?php
                            try{
                                $todoTask = "SELECT task.id AS taskID, task.name AS name, task.time AS time, task.important AS important, task.done as done, to_do_folder.name AS folder FROM to_do_folder, task WHERE task.folder_id = to_do_folder.id AND to_do_folder.user_id = '$userID'AND task.date = CURDATE() ORDER BY task.time, to_do_folder.name";
                                $stmtTask = $db->getConn()->prepare($todoTask);
                                $stmtTask->execute();
                                if ($stmtTask->rowCount() > 0) {
                                    $resultTask = $stmtTask->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($resultTask as $t){
                        ?>
                                        <tr style="<?=$t["done"] == 1 ? "text-decoration: line-through;":""?>" class="<?=$t["important"] == 1 ? "important":""?>">
                                            <td>
                                               <a href="operations/setDone.php?taskID=<?=$t["taskID"]?>&done=<?=$t["done"] == 1 ? "true":"false"?>"><i class="fas fa-<?=$t["done"] == 1 ? "times-circle red-times":"check-circle green-check"?>"></i></a>
                                            </td>
                                            <td><?=$t["folder"].": ".$t["name"]?></td>
                                            <td><?= date('H:i', strtotime($t["time"]));?></td>
                                        </tr>
                        <?php
                                    }
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }   
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- END TO DO LIST -->
                
                <!-- CHALLENGE -->
                <div>
                    <h5>Pending</h5>
                    <table class="table">
                        <?php
                            try{
                                $todoTask = "SELECT task.id AS taskID, task.name AS name, task.time AS time, task.important AS important, task.done as done, to_do_folder.name AS folder FROM to_do_folder, task WHERE task.folder_id = to_do_folder.id AND to_do_folder.user_id = '$userID'AND task.date = DATE('0000-00-00') ORDER BY task.time";
                                $stmtTask = $db->getConn()->prepare($todoTask);
                                $stmtTask->execute();
                                if ($stmtTask->rowCount() > 0) {
                                    $resultTask = $stmtTask->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($resultTask as $t){
                                        if($t["done"] == "0"){
                        ?>
                                        <tr class="<?=$t["important"] == 1 ? "important":""?>">
                                            <td>
                                               <a href="operations/setDone.php?taskID=<?=$t["taskID"]?>&done=<?=$t["done"] == 1 ? "true":"false"?>"><i class="fas fa-<?=$t["done"] == 1 ? "times-circle red-times":"check-circle green-check"?>"></i></a>
                                            </td>
                                            <td><?=$t["folder"].": ".$t["name"]?></td>
                                            <td><?= date('H:i', strtotime($t["time"]));?></td>
                                        </tr>
                        <?php
                                        }
                                    }
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }   
                        ?>
                    </table>
                </div>
                <!-- END CHALLENGE -->
                
                <!-- CHALLENGE -->
                <div>
                    <h5>Challenge</h5>
                    <table class="table">
                        <?php
                            try{
                                $todoTask = "SELECT to_do_folder.name AS folder, challenge.name AS name, daily_challenge.id AS dailyID, daily_challenge.done AS done FROM daily_challenge, challenge, to_do_folder WHERE challenge.id = daily_challenge.challenge_id AND to_do_folder.id = challenge.folder_id AND daily_challenge.date = CURDATE() AND to_do_folder.user_id = $userID";
                                $stmtTask = $db->getConn()->prepare($todoTask);
                                $stmtTask->execute();
                                if ($stmtTask->rowCount() > 0) {
                                    $resultTask = $stmtTask->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($resultTask as $t){
                        ?>
                                        <tr style="<?=$t["done"] == 1 ? "text-decoration: line-through;":""?>">
                                            <td>
                                               <a href="operations/setDone.php?challengeID=<?=$t["dailyID"]?>&done=<?=$t["done"] == 1 ? "true":"false"?>"><i class="fas fa-<?=$t["done"] == 1 ? "times-circle red-times":"check-circle green-check"?>"></i></a>
                                            </td>
                                            <td><?=$t["folder"].": ".$t["name"]?></td>
                                        </tr>
                        <?php
                                    }
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }   
                        ?>
                    </table>
                </div>
                <!-- END CHALLENGE -->
            </div>
        </div>
    </body>
</html>