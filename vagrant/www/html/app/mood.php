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
            <div class="container-fluid">
                <div class="d-flex justify-content-center my-4 pt-3">
                    <?php
                        try{
                            $userID = $_SESSION["userID"];
                            $sql = "SELECT * FROM mood WHERE user_id = '$userID' AND date = curdate()";
                            //echo $sql;
                            $stmt = $db->getConn()->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $mood = $result[0]['mood'];
                                $description = $result[0]['description'];
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>
                    <form method="POST" action="" class="range-field w-75">
                        <?php
                            $color;
                            $icon;
                            $value;
                            //'Happy','Tired','Angry','Sad','Calm'
                            switch ($mood){
                                case "Calm": $color = "#9039C9"; $icon = "smile"; $value = 0; break;
                                case "Happy": $color = "#54C242"; $icon = "laugh-beam"; $value = 1; break;
                                case "Tired": $color = "#BDBDBD"; $icon = "tired"; $value = 2; break;
                                case "Sad": $color = "#2196F3"; $icon = "sad-tear"; $value = 3; break;
                                case "Angry": $color = "#F93324"; $icon = "angry"; $value = 4; break;
                            }
                        ?>
                        
                        <i style="color: <?=$color?>;" class="far fa-<?=$icon?> fa-7x" id="icon"></i><br>
                        <input type="range" class="border-0" min="0" max="4" value="<?=$value?>" id="moodRange" name="mood"><br>
                        <h5 id="text"><?=$mood?></h5>
                        <textarea maxlength="200" class="form-control" rows="3" placeholder="Description" name="description"><?=$description?></textarea><br>
                        
                        <div class="update-center">
                            <button name="update" type="submit" class="btn btn-primary update">Update</button>
                        </div>
 
                    </form>
                    <?php
                        if(isset($_POST["update"])){
                            $moodName;
                            switch ($_POST["mood"]){
                                case 0: $moodName="Calm"; break;
                                case 1: $moodName="Happy"; break;
                                case 2: $moodName="Tired"; break;
                                case 3: $moodName="Sad"; break;
                                case 4: $moodName="Angry"; break;
                            }
                            $db->updateMood($_SESSION["userID"], $moodName, $_POST["description"]);
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
    <script src="../js/moodChanger.js" type="text/javascript"></script>
</html>