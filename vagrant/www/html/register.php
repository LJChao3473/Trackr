<?php
    include("mustIncludes/ddbb.php");
    include("./mustIncludes/header0.php");
?>
            <?php include("mustIncludes/message.php"); ?>
           
        
        <div class="center-form">
            <img class="icon" src="images/icon.png">
            <form method="POST" action="">
                <div class="form-group">
                    <input type="text" name="fname" class="form-control" aria-labelledby="First Name" placeholder="First Name">
                </div>
                <div class="form-group">
                    <input type="text" name="lname" class="form-control" aria-labelledby="Last Name" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" aria-labelledby="Email Address" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <input type="password" name="passwd" class="form-control" aria-labelledby="Password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="confirmPasswd" class="form-control" aria-labelledby="Password" placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary submit" name="register">Sign Up</button>
            </form>
            <a href="index.php"> <span class="links">Already have an account?</span></a>
            <br>
        </div>


        <?php
            if(isset($_POST["register"])){
                $db->register($_POST["fname"], $_POST["lname"], strtolower($_POST["email"]), $_POST["passwd"], $_POST["confirmPasswd"]);
            }
        ?>
    </body>
</html>