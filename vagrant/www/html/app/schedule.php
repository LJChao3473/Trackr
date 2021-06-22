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
                    header("Location: ./schedule.php");
                }
                if(isset($_GET["decrease"])){
                    $_SESSION["day"]--;
                    if($_SESSION["day"] < 0){
                        $_SESSION["day"] = 6;
                    }
                    header("Location: ./schedule.php");
                }
            ?>
            <div class="center-task">
                <a href="./schedule.php?decrease=true" class="arrow left"></a>
                <a href="./schedule.php?increase=true" class="arrow right"></a>
                <h5 class="old-months"><?=$days[$_SESSION["day"]]?></h5>
            </div>
            <?php
                try{
                    $userID = $_SESSION["userID"];
                    $sqlScheduler = "SELECT * FROM scheduler WHERE user_id = '$userID' AND day = '".$days[$_SESSION["day"]]."' order by initial_time, end_time ASC;";
                    $stmt = $db->getConn()->prepare($sqlScheduler);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $i){
                            ?>
                            <div>
                                <h5><?=date("H:i",strtotime($i["initial_time"]) - strtotime('TODAY'))." - ".date("H:i",strtotime($i["end_time"]) - strtotime('TODAY'))." > ".$i["name"]?></h5>
                                <div class="container">
                                    <table class="table">
                                        <tbody>
                                            <?php
                                                $sqlSchedule = "SELECT * FROM schedule WHERE scheduler_id = '".$i["id"]."' order by time";
                                                $stmt2 = $db->getConn()->prepare($sqlSchedule);
                                                $stmt2->execute();
                                                if ($stmt2->rowCount() > 0) {
                                                    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result2 as $y){
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?=$y["name"]?></td>
                                                    <td><?=date("H:i",strtotime($y["time"]) - strtotime('TODAY'));?></td>
                                                </tr>
                                                <?php
                                                    }
                                                }else{
                                                    echo "<tr><td>No tasks</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        echo "<h6 class='no-data'>No data to show</h6> <br>";
                    }
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }    
            ?>
             <div class="center-form">
                 <a href="mod/schedulerMod.php?day=<?=$days[$_SESSION["day"]]?>" class="button-search"><i class="fas fa-pencil-alt"></i> Edit</a>
            </div>
        </div>
    </body>
</html>