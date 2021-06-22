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
            <h2>Contacts</h2>
            <br>
            <div class="center-task">
                <a class="add-contact" href="mod/contactMod.php"><i class="fas fa-user-plus"></i> Add Contact</a>
            </div>

            <br>
            <?php
                try{
                    $userID = $_SESSION["userID"];
                    $sql = "SELECT * FROM contact WHERE user_id = '$userID'";
                    $stmt = $db->getConn()->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $i){
                            
                            ?>
                            <div class="border-task contact">
                                <a href="../operations/deleteEntry.php?contactID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/eliminar.png"></a>
                                <a href="mod/contactMod.php?contactID=<?=$i["id"]?>"><img class="icon-pictures" src="../images/editar.png"></a> <br>
                                <i class="fas fa-user-circle fa-2x icon-avatar"></i>
                                <div class="center-task">
                                    <span class="align-contact-name"><?=$i["fname"]." ".$i["lname"]?></span> <br>
                                    <span class="align-contact-details"><?=$i["telephone_no"]?></span> <br><br>
                                </div>
                            </div>

            

                            <?php
                        }
                    }
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }               
            ?>
        </div>
    </body>
</html>