<?php
    include("mustIncludes/ddbb.php");
    include("./mustIncludes/header0.php");
?>
        <?php include("mustIncludes/message.php"); ?>
        <div  class="center-form">
            <img class="icon" src="images/icon.png">
            <form method="POST" action="">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" aria-labelledby="Email Address" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <input type="password" name="passwd" class="form-control" aria-labelledby="Password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary submit" name="login">Sign In</button>
            </form>
            
            <a href="register.php"> <span class="links">Create an account?</span></a><br>
            <a href="#"> <span class="links">Forget your password?</span></a>
        </div>

        
        <?php
            if(isset($_POST["login"])){
                $db->login(strtolower($_POST["email"]), $_POST["passwd"]);
            }
        ?>
    </body>
</html>