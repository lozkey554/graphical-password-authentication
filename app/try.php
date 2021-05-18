<?php
    session_start();
    include "app.connect.php";
    // start connection
    $startcon = new dbconnect;
    $conn = $startcon->connection();


    $tmpname = $_FILES['file']['tmp_name'];
    $realname = $_FILES['file']['name'];

    if(isset($realname))
    {
    	if(!empty($realname))
    	{
            $location = "../puzzleimage/";
            $move = move_uploaded_file($tmpname, $location.$realname);
            if($move) echo 0;
    	}
    }







