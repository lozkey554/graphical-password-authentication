<?php

class dbconnect {
    private $host;
    private $user;
    private $password;
    private $conn;

    function connection(){
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        
        try {
            $this->conn = mysqli_connect($this->host, $this->user, $this->password);
            if(!$this->conn) throw new Exception("Server not connected");
            else{
                $select = mysqli_select_db($this->conn, "puzzle_auth");
                if($select) return $this->conn;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }

    } 
}