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
                $fname = "";
                $lname = "";
                $tel = "";
                $mail = "";
                $street = "";
                $zip = "";
                $city = "";
                $country = "";
                if(isset($_GET["contactID"])){
                    $sql = "SELECT * FROM contact WHERE id = '".$_GET["contactID"]."'";
                    $stmt = $db->getConn()->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $fname = $result[0]["fname"];
                    $lname = $result[0]["lname"];
                    $tel = $result[0]["telephone_no"];
                    $mail = $result[0]["email"];
                    $street = $result[0]["street"];
                    $zip = $result[0]["zip_code"];
                    $city = $result[0]["city"];
                    $country = $result[0]["country"];
                    
                }
            ?>
            
            <h2>Add Contacts</h2>
            <div >
                <form method="POST">
                    <table class="center-form contact">
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fas fa-user">
                                </td>
                                <td colspan="2">
                                    <input name="fname" class="input-name" type="text" value="<?=$fname?>" placeholder="First Name" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"><input name="lname" class="input-name" type="text" value="<?=$lname?>" placeholder="Last Name"></input> <br></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-phone"></i>
                                </td>
                                <td colspan="2"><input name="tel" class="input-name" type="text" value="<?=$tel?>" placeholder="Telephone Number"></input></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="far fa-envelope"></i>
                                </td>
                                <td colspan="2"><input name="mail" class="input-name" type="text" value="<?=$mail?>" placeholder="Email"></input></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-home"></i>
                                </td>
                                <td colspan="2"><input name="street" class="input-name" type="text" value="<?=$street?>" placeholder="Street"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input name="zip" class="input-address" type="text" value="<?=$zip?>" placeholder="Zip"></input></td>
                                <td><input name="city" class="input-address" type="text" value="<?=$city?>" placeholder="City"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"><input name="country" class="input-name" type="text" value="<?=$country?>" placeholder="Country"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button class="cancel-contact" type="reset"><i class="fas fa-times"></i></button></td>
                                <td><button class="save-contact" type="submit" name="submit"><i class="fas fa-check"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php
                    if(isset($_POST["submit"])){
                        if(isset($_GET["contactID"])){
                            $db->updateContact($_GET["contactID"], $_POST["fname"], $_POST["lname"], $_POST["street"], $_POST["zip"], $_POST["city"], $_POST["country"], $_POST["mail"], $_POST["tel"]);
                        }else{
                            $db->addContact($_SESSION["userID"], $_POST["fname"], $_POST["lname"], $_POST["street"], $_POST["zip"], $_POST["city"], $_POST["country"], $_POST["mail"], $_POST["tel"]);
                        }
                    }
                ?> 
            </div>
        </div>
    </body>
</html>