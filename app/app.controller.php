<?php
    session_start();
    include "app.connect.php";

date_default_timezone_set("Africa/Lagos");

    // start connection
    $startcon = new dbconnect;
    $conn = $startcon->connection();

    $action = @$_POST["action"];
    switch ($action) {
        case 'registerUser':
            echo (new app)->registerUser();
            break;
        case 'showPassword':
            echo (new app)->showPassword();
            break;
    case 'loginUser':
        echo (new app)->loginUser();
        break;
    case 'verify_user':
        echo (new app)->checkRecoveryEmail();
        break;
    case 'setRecovery':
        echo (new app)->securityQuestion();
        break;
    case 'sendAnswer':
        echo (new app)->sendAnswer();
        break;

    case 'resetPassword':
        echo (new app)->resetPassword();
        break;

        default:
            # code...
            break;
    }

    class app{
        public $conn;
        private $username;
        private $password;

        function clean_string($d){
            global $conn;
            return mysqli_real_escape_string($conn, $d);
        }


        public function checkIfEmailExist($email, $conn){

            $query = $conn->query("SELECT * FROM user_account WHERE `email` = '$email' AND `status` = 1") or die(mysqli_error($conn));
            if(mysqli_num_rows($query) > 0){
                $status = "True";
            }
            else{
                $status = "False";
            }

            return $status;

        }
        
        
        function registerUser()
        {
            global $conn;
            $data = $_POST["dataValue"];
            $exp = explode(",", $data[1]);
            
            $name = $data[0];
            // $username = $data[1];
            $email = $data[4];
            
            $password = "";

            foreach($exp as $key)
            {
                $password.= hash("md5",$key).",";
            }
            $e = explode(",", $password);
            $e = array_filter($e);
            $im = implode(",", $e);
            

        // check if user already exists
        $qury = $conn->query("SELECT email FROM user_account WHERE `email` = '$email'") or die(mysqli_error($conn));
            
            if(mysqli_num_rows($qury) > 0)
            {
                $response = 0;
            }
            else{
                $ins = $conn->query("INSERT INTO user_account(fullname,email, passwrd, picture, grid_size, `status`) VALUES('$name', '$email', '$im', '$data[2]', '$data[3]', 0)") or mysqli_error($conn);

                if($ins) {
                    @session_start();
                    $_SESSION["user_id"] = $email;
                    $_SESSION["status"] = "reg";
                    $response = 1;
                }
            }
                return json_encode(["response"=>$response]);
		
    }

    function securityQuestion()
    {
        global $conn;
        $data = $_POST["dataValue"];
        
        $question = $data[0];
        $answer = strtolower($data[1]);
        $email = $data[2];

        $ins = $conn->query("UPDATE user_account SET security_question = '$question', security_ans = '$answer', `status` = 1 WHERE `email` = '$email'") or mysqli_error($conn);

            if ($ins) {
                $response = 1;
            }
        
        return json_encode(["response" => $response]);
    }

    function showPassword(){
        global $conn;
        $username = $_POST["dataValue"];
       
        $qury = $conn->query("SELECT * FROM user_account WHERE `email` = '$username'") or die(mysqli_error($conn));
        if (mysqli_num_rows($qury) > 0) {
            $x = mysqli_fetch_array($qury);
            $account_status = $x["status"];
            $picture = $x["picture"];
            $grid_size = $x["grid_size"];

            if($account_status == 0){
                $_SESSION["user_id"] = $username;
                $status = 2; //registration not completed  
            }
           else{
            $status = 1;
           }
        }
        else $status=0;

        return json_encode(["picture" => @$picture , "grid_size" => @$grid_size, "status"=>$status]);
    }

    function loginUser(){
        global $conn;
        $data = $_POST["user_id"];

        $username = $data[1];
        $oldp = $data[0];
        $exp = explode(",", $oldp);
        
        $im = "";

        foreach ($exp as $key) {
            $im .= hash("md5", $key) . ",";
        }
        $e = explode(",", $im);
        $e = array_filter($e);
        $password = implode(",", $e);

        // check if user already exists
        $qury = $conn->query("SELECT * FROM user_account WHERE `email` = '$username' AND passwrd = '$password'") or die(mysqli_error($conn));

        if (mysqli_num_rows($qury) > 0) {
            $_SESSION["user_id"] = $username;
            $_SESSION["status"] = "login";
            $response = 0;
            
        }
        else{
            $response = 1;
        }
        return json_encode(["response" => @$response]);

    }

    function resetPassword()
    {
        global $conn;
        $data = $_POST["user_id"];

        $username = $data[1];
        $oldp = $data[0];
        $exp = explode(",", $oldp);

        $password = "";

        foreach ($exp as $key) {
            $password .= hash("md5", $key) . ",";
        }
        $e = explode(",", $password);
        $e = array_filter($e);
        $im = implode(",", $e);

        $ins = $conn->query("UPDATE user_account SET `passwrd` = '$im' WHERE `email` = '$username'") or die(mysqli_error($conn));
        
        if ($ins) {       
            $response = 0;
        } else {
            $response = 1;
        }
        return json_encode(["response" => @$response]);
    }

    function optGenerator()
    {
        $n = 6;
        $generator = "1357902468";

        $result = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    function selectSomething($value){
        global $conn;

        return $conn->query("SELECT * FROM user_account WHERE `email` = '$value'") or die(mysqli_error($conn));
    }


    function checkRecoveryEmail(){
        global $conn;

        $v = $_POST["dataValue"];

        // verify email exists
        $emailverify = $this->checkIfEmailExist($v, $conn);
        $question = "";

        if($emailverify == "True"){
            $status = 1;
            // $_SESSION["email"] = $v;
            $select = $conn->query("SELECT * FROM user_account WHERE `email` = '$v' AND `status` = 1") or die(mysqli_error($conn));
            $row = mysqli_fetch_array($select);
            
            $question = $row["security_question"];
    }
        elseif($emailverify == "False")
        {
            $status = 0;
        }

        return json_encode(["status" => $status, "question"=>$question, "user_id"=>$v]);
    }

    function sendAnswer()
    {
       global $conn;
        $v = $_POST["dataValue"];
        
        $select = $conn->query("SELECT * FROM user_account WHERE `email` = '$v[0]'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($select);

        $answer = $row["security_ans"];
        if($answer == $v[1]){
            $status = 1;
        }
        else{
            $status = 0;
        }
        return json_encode(["status" => $status, "picture"=>$row["picture"], "grid_size"=>$row["grid_size"]]);
    }


    public function logout(){
        session_start();
        session_destroy();
        header("location: ./index.php");
    }

    // get ip address
    function getIpAddress()
    {
        if (!empty($_SERVER["HTTP-CLIENT-IP"])) {
            $ipAddress = $_SERVER["HTTP-CLIENT-IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ipAddress = $_SERVER["REMOTE_ADDR"];
        }
        return $ipAddress;
    }


    function checkifComplete($email){

        global $conn;
        $query = $conn->query("SELECT * FROM user_account WHERE `email` = '$email'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($query);
        $status = $row["status"];

        if(isset($email) && $status == 0){
            header("location: ./register.php");
        }
        

    }
    

    }


   





