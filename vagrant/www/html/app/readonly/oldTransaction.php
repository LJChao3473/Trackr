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
                if(!isset($_SESSION["curDate"])){
                    $_SESSION["curDate"] = strtotime("now");
                }
                if(isset($_GET["increase"])){
                    $_SESSION["curDate"] = strtotime("+1 month", $_SESSION["curDate"]);
                    header("Location: ./oldTransaction.php");
                }
                if(isset($_GET["decrease"])){
                    $_SESSION["curDate"] = strtotime("-1 month", $_SESSION["curDate"]);
                    header("Location: ./oldTransaction.php");
                }
            ?>
            
            <div>
                <a href="./oldTransaction.php?decrease=true" class="arrow left"></a>
                <a href="./oldTransaction.php?increase=true" class="arrow right"></a>
                <h5 class="old-months"><?=date("F, Y", $_SESSION["curDate"]);?></h5>
                
                <table class="table">
                    <tbody>
                        <?php
                            try{
                                //find finantial ID
                                $month = date("m", $_SESSION["curDate"]);
                                $year = date("Y", $_SESSION["curDate"]);
                                $userID = $_SESSION["userID"];
                                $sql = "SELECT * FROM financial WHERE user_id = $userID AND month = $month AND year = $year";
                                $stmt = $db->getConn()->prepare($sql);
                                $stmt->execute();
                                $financialID = 0;
                                if ($stmt->rowCount() > 0) {
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $financialID = $result[0]["id"];
                                    $sqlTransaction = "SELECT * FROM transaction WHERE financial_id = '$financialID' order by date";
                                    $stmtTransaction = $db->getConn()->prepare($sqlTransaction);
                                    $stmtTransaction->execute();
                                    if ($stmtTransaction->rowCount() > 0) {
                                        $result = $stmtTransaction->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $i){
                                            if($i["type"] == "expenses"){
                                                $table = "expenses";
                                                $sign = "-";
                                            }else{
                                                $table = "income";
                                                $sign = "+";
                                            }
                                            ?>
                                            <tr>
                                                <td><?=date("d/m", strtotime($i["date"]));?></td>
                                                <td><?=$i["name"]?></td>
                                                <td><span class="table-<?=$table?>"><?=$sign?><?=$i["quantity"]?>€</span></td>
                                            </tr>
                                            <?php
                                        }
                                    }else{
                                        echo "<tr><td><h6 class='no-data'>No data to show</h6> </td></tr>";
                                    }
                                }else{
                                    echo "<tr><h6 class='no-data'>No data to show</h6> </td></tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>