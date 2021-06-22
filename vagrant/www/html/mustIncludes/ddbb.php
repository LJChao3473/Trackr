<?php
    session_start();
    ob_start();
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    class db{
        private $servername;
        private $username;
        private $password;
        private $dbname;
        private $conn;
        public function __construct($servername, $username, $password, $dbname) {
            $this->servername = $servername;
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
            $this->connect();

        }
        public function __destruct() {
            $conn = null; 
        }
        public function connect(){
            try {
              $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
              // set the PDO error mode to exception
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //echo "Connected successfully <br>";
            } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage() . "<br>";
            }
        }
        public function getConn(){
            return $this->conn;
        }
        
        //LOGIN / REGISTER
        public function login($email, $passwd){
            $hashPasswd = hash('MD5', $passwd);
            try{
                $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$hashPasswd'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION["userFName"] = $result[0]['fname'];
                    $_SESSION["userLName"] = $result[0]['lname'];
                    $_SESSION["userID"] = $result[0]['id'];
                    
                    //Create new mood upon login
                    $this->createMood($_SESSION["userID"]);
                    $this->createFinancial($_SESSION["userID"]);
                    $this->dailyChallenge($_SESSION["userID"]);
                    $this->dailyScheduleTask($_SESSION["userID"]);
                    header("Location: ../main.php");
                }else{
                    $_SESSION["message"] = "Invalid password or incorrect mail";
                    $_SESSION["alert"] = "warning";
                    header("Location: ../");
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        
        public function register($fname, $lname,$email, $passwd, $confirmPasswd){
            if($passwd == $confirmPasswd){
                try{
                    
                    $sql = "SELECT * FROM user WHERE email = '$email'";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() == 0) {
                        try{
                            $hashPasswd = hash('MD5', $passwd);
                            $sql2 = "INSERT INTO `user` (fname, lname, email, `password`) VALUES ('$fname', '$lname', '$email', '$hashPasswd')";
                            $_SESSION["message"] = "Your account have been created";
                            $_SESSION["alert"] = "success";
                            $this->conn->exec($sql2);
                            $this->login($email, $passwd);
                        }catch (Exception $ex){
                            echo "Error: " . $e->getMessage();
                        }
                    }else{
                        $_SESSION["message"] = "Email already in use";
                        $_SESSION["alert"] = "warning";
                        header("Location: ../register.php");
                    }
                } catch (Exception $ex) {
                    echo "Error: " . $e->getMessage();
                }
            }else{
                $_SESSION["message"] = "Password doesn't match";
                $_SESSION["alert"] = "warning";
                header("Location: ../register.php");
            }
        }
        
        //MOOD
        //dayle upon login, it will create a new entry to the database if doesn't exists
        public function createMood($userID){
            $moodSQL = "SELECT * FROM mood WHERE user_id = '$userID' AND date = CURDATE()";
            $moodstmt = $this->conn->prepare($moodSQL);
            $moodstmt->execute();
            if ($moodstmt->rowCount() == 0) {
                try{
                    $sql = "INSERT INTO mood(user_id, mood, date) VALUES ('$userID', 'Calm', CURDATE())";
                    $this->conn->exec($sql);
                } catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }
            }
        }
        
        public function updateMood($userID, $mood, $descrip){
            
            try{
                $sql = "UPDATE mood SET mood='$mood', description = '".addslashes($descrip)."' WHERE user_id = '$userID' AND date = CURDATE()";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "Mood updated";
                $_SESSION["alert"] = "success";
                header("Location: /app/mood.php");
            }catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
        
        //Contact
        public function addContact($userID, $fname, $lname, $street, $zip, $city, $country, $mail, $tel){
            try{
                $sql = "INSERT INTO contact (user_id, fname, lname, street, zip_code, city, country, email, telephone_no) VALUES ('$userID', '$fname', '$lname', '$street', '$zip', '$city', '$country', '$mail', '$tel');";
                $_SESSION["message"] = "New contact added";
                $_SESSION["alert"] = "success";
                $this->conn->exec($sql);
                header("Location: /app/contact.php");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        
        public function updateContact($contactID, $fname, $lname, $street, $zip, $city, $country, $mail, $tel){
            try{
                $sql = sprintf("UPDATE contact SET fname='$fname', lname='$lname', street='$street', zip_code='$zip', city='$city', country='$country', email='$mail', telephone_no='$tel' WHERE id = '$contactID'");
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "Contact updated";
                $_SESSION["alert"] = "success";
                header("Location: /app/contact.php");
            }catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
        
        //Financial
        //Montly if the user login, creates a new financial entry to the database
        public function createFinancial($userID){
            $finanSQL = "SELECT * FROM financial WHERE user_id = '$userID' AND month = MONTH(CURDATE()) AND YEAR(CURDATE())";
            $finanstmt = $this->conn->prepare($finanSQL);
            $finanstmt->execute();
            if ($finanstmt->rowCount() == 0) {
                try{
                    $sql = "INSERT INTO financial (user_id, total, total_expenses, total_income, month, year) VALUES ('$userID', 0, 0, 0, MONTH(CURDATE()), YEAR(CURDATE()));";
                    $this->conn->exec($sql);
                }catch (Exception $e){
                    echo "Error: " . $e->getMessage();
                }
            }
        }
        
        public function addTransaction($financialID, $type, $name, $amount){
            try{
                $sql = "INSERT INTO transaction (financial_id, name, type, quantity, date) VALUES ('$financialID', '$name', '$type', '$amount', CURDATE());";
                $this->conn->exec($sql);
                if($type == "Income"){
                    $sqlFinancial = "UPDATE financial SET total = total + $amount, total_income = total_income + $amount WHERE id = '$financialID'";
                }else{
                    $sqlFinancial = "UPDATE financial SET total = total - $amount, total_expenses = total_expenses + $amount WHERE id = '$financialID'";
                }
                $stmt = $this->conn->prepare($sqlFinancial);
                $stmt->execute();
                $_SESSION["message"] = "New transaction/s added";
                $_SESSION["alert"] = "success";
                header("Location: /app/expenses.php");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        
        //To do List
        public function addFolder($userID, $name){
            try{
                $sql =  sprintf("INSERT INTO to_do_folder (user_id, name) VALUES ('$userID', '$name')");
                $this->conn->exec($sql);
                $_SESSION["message"] = "New To Do Folder added";
                $_SESSION["alert"] = "success";
                header("Location: ./todolist.php");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        
        public function updateFolder($folderID, $name){
            try{
                $sql = "UPDATE to_do_folder SET name='$name' WHERE id='$folderID'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "To do folder updated";
                $_SESSION["alert"] = "success";
                header("Location: ./todolist.php");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }


        //Task List
        public function addTask($folderID, $name, $description, $date, $time, $important){
            try{
                $sql =  sprintf("insert into task (folder_id, `name`, description,  `date`, `time`, important) values ('$folderID', '$name', '$description', '$date', '$time', $important);");
                $this->conn->exec($sql);
                $_SESSION["message"] = "New task added";
                $_SESSION["alert"] = "success";
                //header("Location: /app/tasklist.php?folderID=$folderID");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        public function updateTask($taskID, $name, $description, $date, $time, $important){
            try{
                $sql = sprintf("UPDATE task SET name='$name', description = '$description', date = '$date', time = '$time', important = '$important' WHERE id = '$taskID'");
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "Task updated";
                $_SESSION["alert"] = "success";
                //header("Location: /app/tasklist.php?folderID=$folderID");
            }catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
        public function addChallenge($userID, $folderID, $name, $description){
            try{
                $sql =  sprintf("insert into challenge (folder_id, `name`, description) values ('$folderID', '$name', '$description');");
                $this->conn->exec($sql);
                $this->dailyChallenge($userID);
                $_SESSION["message"] = "New challenge added";
                $_SESSION["alert"] = "success";
                header("Location: /app/tasklist.php?folderID=$folderID");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        public function updateChallenge($challengeID, $folderID, $name, $description){
            try{
                $sql = sprintf("UPDATE challenge SET name='$name', description = '$description' WHERE id = '$challengeID'");
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "Challenge updated";
                $_SESSION["alert"] = "success";
                header("Location: /app/tasklist.php?folderID=$folderID");
            }catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
        
        public function dailyChallenge($userID){
            try{
                $sqlFolder = "SELECT * FROM to_do_folder WHERE user_id = '$userID'";
                $stmtFolder = $this->conn->prepare($sqlFolder);
                $stmtFolder->execute();
                if ($stmtFolder->rowCount() > 0) {
                    $resultFolder = $stmtFolder->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultFolder as $i){
                        $sqlChallenge = "SELECT * FROM challenge WHERE folder_id = '".$i["id"]."'";
                        $stmtChallenge = $this->conn->prepare($sqlChallenge);
                        $stmtChallenge->execute();
                        if ($stmtChallenge->rowCount() > 0) {
                            $resultChallenge = $stmtChallenge->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($resultChallenge as $i){
                                $sqlDaily = "SELECT * FROM daily_challenge WHERE challenge_id = '".$i["id"]."' AND date = CURDATE()";
                                $stmtDaily = $this->conn->prepare($sqlDaily);
                                $stmtDaily->execute();
                                if ($stmtDaily->rowCount() == 0) {
                                    $sql = "insert into daily_challenge (challenge_id, `date`) values ('".$i["id"]."', CURDATE());";
                                    $this->conn->exec($sql);
                                }
                            }
                        }
                    }
                }
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        public function addContactTask($taskID, $contactID){
            try{
                $sql =  sprintf("insert into contact_task (task_id, contact_id) values ('$taskID', '$contactID');");
                $this->conn->exec($sql);
                //header("Location: /app/tasklist.php?folderID=$folderID");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        public function deleteContactTask($taskID){
            try{
                $sql =  sprintf("DELETE FROM contact_task WHERE task_id = '$taskID'");
                $this->conn->exec($sql);
                //header("Location: /app/tasklist.php?folderID=$folderID");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        
        //Scheduler
        public function addScheduler($userID, $day, $name, $iTime, $eTime){
            try{
                $sql =  sprintf("INSERT INTO scheduler (user_id, day, name, initial_time, end_time) VALUES ('$userID', '$day', '$name', '$iTime', '$eTime')");
                echo $sql;
                $this->conn->exec($sql);
                $_SESSION["message"] = "New Scheduler added";
                $_SESSION["alert"] = "success";
                header("Location: /app/mod/schedulerMod.php?day=$day");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        public function updateScheduler($schedulerID, $day, $name, $iTime, $eTime, $pageDay){
            try{
                $sql = "UPDATE scheduler SET name='$name',day = '$day', initial_time = '$iTime', end_time = '$eTime' WHERE id='$schedulerID'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "Scheduler updated";
                $_SESSION["alert"] = "success";
                header("Location: /app/mod/schedulerMod.php?day=$pageDay");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        
        public function dailyScheduleTask($userID){
            try{
                $days = [
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    0 => 'Sunday'
                  ];
                $today = date('w', strtotime("now"));
                $scheduleSQL = "SELECT schedule.id FROM schedule, scheduler WHERE schedule.scheduler_id = scheduler.id AND scheduler.user_id = '$userID' AND scheduler.day = '".$days[$today]."' order by initial_time, end_time;";
                echo $scheduleSQL."<br>";
                $stmtSchedule = $this->conn->prepare($scheduleSQL);
                $stmtSchedule->execute();
                if ($stmtSchedule->rowCount() > 0) {
                    $resultSchedule = $stmtSchedule->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultSchedule as $i){
                        $taskSQL = "SELECT * FROM schedule_task WHERE schedule_id = '".$i["id"]."' AND date = CURDATE()";
                        
                        echo $taskSQL;
                        $stmtTask = $this->conn->prepare($taskSQL);
                        $stmtTask->execute();
                        if ($stmtTask->rowCount() == 0) {
                            $insert = "INSERT INTO schedule_task (schedule_id, date, done) VALUES ('".$i["id"]."', CURDATE(), 0)";
                            $this->conn->exec($insert);
                        }
                    }
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }   
        }
        
        public function addSchedule($schedulerID,$name, $time){
            try{
                $sql =  sprintf("INSERT INTO schedule (scheduler_id, name, time) VALUES ('$schedulerID', '$name', '$time')");
                echo $sql;
                $this->conn->exec($sql);
                $_SESSION["message"] = "New Schedule added";
                $_SESSION["alert"] = "success";
                $this->dailyScheduleTask($_SESSION["userID"]);
                header("Location: /app/mod/scheduleMod.php?schedulerID=$schedulerID");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        public function updateSchedule($schedulerID, $id, $name, $time){
            try{
                $sql = "UPDATE schedule SET name='$name', time = '$time' WHERE id='$id'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $_SESSION["message"] = "Schedule task updated";
                $_SESSION["alert"] = "success";
                header("Location: /app/mod/scheduleMod.php?schedulerID=$schedulerID");
            }catch (Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
    $db = new db("localhost", "admin", "admin", "Trackr");
    $db->connect();
?>