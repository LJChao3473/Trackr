<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Trackr</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link type="text/css" rel="stylesheet" href="/mustIncludes/styles-desktop.css?version=51">
    <?php
        if($_SERVER["PHP_SELF"] == "/app/calendar.php"){
    ?>
        <link type="text/css" rel="stylesheet" href="/mustIncludes/styles-calendar.css?version=51">
    <?php
        }
    ?>
    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
        if(!isset($_SESSION)){
            session_start(); 
        } 
        if(!isset($_SESSION["userID"])){
            header("Location: /");
        }
    ?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <a href="/main.php"><span class="profile-name"><?=$_SESSION["userFName"]. " " .$_SESSION["userLName"]?></span></a>
            </div>
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
                        switch ($mood){
                            case "Calm": $color = "#9039C9"; $icon = "smile"; break;
                            case "Happy": $color = "#54C242"; $icon = "laugh-beam"; break;
                            case "Tired": $color = "#BDBDBD"; $icon = "tired"; break;
                            case "Sad": $color = "#2196F3"; $icon = "sad-tear"; break;
                            case "Angry": $color = "#F93324"; $icon = "angry"; break;
                        }
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            ?>
            <div class="sidebar-header">
                <a href="/app/mood.php"><i style="color: <?=$color?>;" class="far fa-<?=$icon?> fa-5x icon-header"></i></a>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="/app/expenses.php"><i class="fas fa-money-bill-wave"></i> Expenses</a>
                </li>
                <li>
                    <a href="/app/todolist.php"><i class="far fa-list-alt"></i> To-do Lists</a>
                </li>
                <li>
                    <a href="/app/schedule.php"><i class="far fa-clock"></i> Schedule</a>
                </li>
                <li>
                    <a href="/app/contact.php"><i class="fas fa-phone"></i> Contact</a>
                </li>
                <li>
                    <a href="/app/calendar.php"><i class="far fa-calendar"></i> Calendar</a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="/operations/logout.php" class="article">Log out</a>
                </li>
            </ul>
        </nav>

    </div>

    <div class="overlay"></div>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="/mustIncludes/navbar.js"></script>
    
