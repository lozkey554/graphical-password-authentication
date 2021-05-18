<?php

@session_start();
    if(!isset($_SESSION["user_id"])) header("location: ./login.php");
    // echo $_SESSION["user_id"];