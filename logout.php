<?php
include "app/app.controller.php";
@session_start();
        if(isset($_SESSION["user_id"])){
            $cl = new app;
            return $cl->logout();
        }


