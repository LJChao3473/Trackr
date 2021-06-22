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
    
                <div id="calendar"></div>

        </div>
        <script type="text/javascript" src="../js/calendar.js"></script>
        <script>
            !function() {
                var data = [

                    <?php
                        $userID = $_SESSION["userID"];
                        $sql = "SELECT * FROM mood WHERE user_id = '$userID'";
                        $stmt = $db->getConn()->prepare($sql);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0) {
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $mood){
                    ?>
                                { eventName: '<?=$mood["description"]?>', calendar: '<?=$mood["mood"]?>', color: '<?=$mood["mood"]?>', date: '<?=$mood["date"]?>' },
                    <?php
                            }
                        }
                        $sql = "SELECT count(*) AS count, date AS date FROM task, to_do_folder WHERE to_do_folder.id = task.folder_id AND to_do_folder.user_id = '$userID' AND task.done = 1 GROUP BY date";
                        $stmt = $db->getConn()->prepare($sql);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0){
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $task){
                                if($task["date"] != "0000-00-00"){
                    ?>
                                    {eventName: 'Task done: <?=$task["count"]?>', calendar: '', color: '', date: '<?=$task["date"]?>'},
                    <?php
                                }
                            }
                        }
                    ?>
                    <?php
                        $sql = "SELECT count(*) as count, daily_challenge.date AS date FROM challenge, to_do_folder, daily_challenge WHERE to_do_folder.id = challenge.folder_id AND daily_challenge.challenge_id = challenge.id AND to_do_folder.user_id = '$userID' AND daily_challenge.done = 1 GROUP BY date";
                        $stmt = $db->getConn()->prepare($sql);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0){
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $challenge){
                                if($challenge["date"] != "0000-00-00"){
                    ?>
                                    {eventName: 'Challenge done: <?=$challenge["count"]?>', calendar: '', color: '', date: '<?=$challenge["date"]?>'},
                    <?php
                                }
                            }
                        }
                    ?>
                    <?php
                        $sql = "SELECT COUNT(*) AS count, schedule_task.date AS date FROM scheduler, schedule, schedule_task WHERE schedule_task.schedule_id = schedule.id AND schedule.scheduler_id = scheduler.id AND schedule_task.done = 1 AND scheduler.user_id = '$userID' GROUP BY schedule_task.date;";
                        $stmt = $db->getConn()->prepare($sql);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0){
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $schedule){
                                if($schedule["date"] != "0000-00-00"){
                    ?>
                                    {eventName: 'Schedule Task done: <?=$schedule["count"]?>', calendar: '', color: '', date: '<?=$schedule["date"]?>'},
                    <?php
                                }
                            }
                        }
                    ?>
                    { eventName: '', calendar: '', color: '', date: '' }
                ];
                var calendar = new Calendar('#calendar', data);
                console.log(data);
            }();
        </script>
    </body>
</html>