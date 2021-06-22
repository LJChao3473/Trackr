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
                try{
                    $userID = $_SESSION["userID"];
                    $sql = "SELECT * FROM financial WHERE user_id = '$userID' AND month = MONTH(CURDATE()) AND year = YEAR(CURDATE())";
                    $stmt = $db->getConn()->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $total = $result[0]["total"];
                        $expenses = $result[0]["total_expenses"];
                        $income = $result[0]["total_income"];
                    }else{
                        $total = 0;
                        $expenses = 0;
                        $income = 0;
                    }
                } catch (Exception $ex) {
                    echo "Error: " . $e->getMessage();
                }
                try{
                    //find finantial ID
                    $sql = "SELECT * FROM financial WHERE user_id = $userID AND month = MONTH(CURDATE()) AND year = YEAR(CURDATE())";
                    $stmt = $db->getConn()->prepare($sql);
                    $stmt->execute();
                    $financialID = 0;
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $financialID = $result[0]["id"];
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            ?>
            <div  class="container container-fluid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <span class="financial-name">Total</span> <br><br>
                            <span class="border-financial total"><?=$total?>€</span>
                        </div>
                        <div class="col">
                            <span class="financial-name">Expenses</span> <br><br>
                            <span class="border-financial"><?=$expenses?>€</span>
                        </div>
                        <div class="col">
                        <span class="financial-name">Income</span> <br><br>
                        <span class="border-financial"><?=$income?>€</span>
                        </div>
                    </div>
                  </div>
                <br>
                <table class="table">
                        <tbody>
                            <?php
                                try{
                                    $sqlTransaction = "SELECT * FROM transaction WHERE financial_id = '$financialID' AND date = CURDATE() order by date";
                                    $stmtTransaction = $db->getConn()->prepare($sqlTransaction);
                                    $stmtTransaction->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                if ($stmtTransaction->rowCount() > 0) {
                                    $result = $stmtTransaction->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $i){ 
                            ?>
                                        <tr>
                                            <td> 
                                                <span class="date"><?=$result[0]["date"]?> </span>
                                                <br>
                                                <?=$i["name"]?>
                                            </td>
                                            <td> 
                                                <br>
                                                <?php
                                                    if($i["type"] == "expenses"){
                                                        $table = "expenses";
                                                        $sign = "-";
                                                    }else{
                                                        $table = "income";
                                                        $sign = "+";
                                                    }
                                                ?>
                                                <span class="table-<?=$table?>"><?=$sign?><?=$i["quantity"]?>€</span>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                <hr>
            
                <div class="center-form">
                    <form method="POST">
                    <h5 class="transaction">Transaction</h5>
                    <div id="transactionForms">
                        <div name="transactionForm">
                            
                        </div>
                    </div>
                    <button class="add-transaction" type="button" id="addTransaction"><i class="fas fa-cart-plus"></i></button>
                    <button class="save-transaction" type="submit" name="addTransaction"><i class="fas fa-check"></i></button>
                </form>
                </div>
            
            
            <?php
                if(isset($_POST["addTransaction"])){
                    if(isset($_POST['name'])){
                        foreach($_POST['name'] as $i=>$transaction){
                            $db->addTransaction($financialID, $_POST['type'][$i], $_POST['name'][$i], $_POST['amount'][$i]);
                        }
                    }
                }
            ?>
            <hr>
            <div class="center-form">
                <h5 class="transaction">
                    <span class="dot"><i class="fas fa-exclamation"></i></span>
                    Old Transactions
                </h5>
                <br>
                
                <a href="./expenses.php?oldTransaction=true" class="button-search">Search</a>
            </div>
                
                <?php
                    if(isset($_GET["oldTransaction"])){
                        $_SESSION["curDate"] = strtotime("now");
                        header("Location: readonly/oldTransaction.php");
                    }
                ?>
            </div>
        </div>
        <script src="../js/moreTransaction.js" type="text/javascript"></script>
    </body>
</html>
