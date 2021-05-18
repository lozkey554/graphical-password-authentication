<?php

include "app/app.connect.php";
include "redirect.php";

@session_start();
$startcon = new dbconnect;
$conn = $startcon->connection();

if (isset($_SESSION["user_id"])){
    $id = $_SESSION['user_id'];

    $qury = $conn->query("SELECT * FROM user_account WHERE `email` = '$id'") or die(mysqli_error($conn));
    $info = mysqli_fetch_array($qury);

    $fullname = $info['fullname'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzle Authentication</title>

    <link rel="stylesheet" href="css/css/bootstrap.min.css" />

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/image-puzzle.js"></script>


    <style>
        #userid {
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="alert alert-primary text-center">
            <h3> Web-based Puzzle lock Authentication System </h3>
            <p style="margin-bottom:30px; font-size:20px;">
                <a href="./logout.php" style="float: right;text-decoration: none;"> Logout </a>
            </p>

        </div>

        <?php
        if (isset($_SESSION["user_id"]) && isset($_SESSION["status"]) && $_SESSION["status"] == "reg") { ?>
            <div class="alert alert-success text-center message-slide"> Registration is Successful </div>
        <?php unset($_SESSION["status"]);
        }
        elseif (isset($_SESSION["user_id"]) && isset($_SESSION["status"]) && $_SESSION["status"] == "login") { ?>
            <div class="alert alert-success text-center message-slide"> Login Successful </div>
        <?php unset($_SESSION["status"]);
        }

        ?>
        <div class="text-center">
            <?php

            echo "<h3> Welcome <span id = 'userid'> $fullname </span> </h3>";

            ?>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $(".message-slide").slideDown(3000).slideUp(3000);
        });
    </script>

</body>

</html>