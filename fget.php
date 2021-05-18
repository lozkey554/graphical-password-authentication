<?php
session_start();
if (isset($_SESSION["email"])) {
    $user_id = $_SESSION["email"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzle Authentication</title>
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/css/bootstrap.min.css">
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/image-puzzle.js"></script>

    <style>
        #collage #sortable {
            border: 2px solid #a46;
            list-style-type: none;
            display: inline-block;
            margin: 10px;
            padding: 0;
            width: 356px;
        }

        #reset {
            text-decoration: none;
            font-size: 13px;
        }

        #reset:hover {
            color: darkred;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="alert nav-alert text-center">
            <a href="login.php" style="float: left;text-decoration: none;color: yellowgreen;font-size: 25px;">Back</a>
            Web-based Puzzle lock Authentication System
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="jumbotron">
                    <div id="p-reset">
                        <h3 style="text-align: center;">Password Reset</h3>
                        <span id="message"></span>

                        <form action="" method="post" id="myform">
                            <!-- <p id="panel-main"> -->
                            <div class="input-group mb-2">
                                <label for="username" style="font-size:14px;">Email&nbsp;</label>
                                <input type="text" name="username" id="username" placeholder="Enter Email address" class="form-control" style="height: 30px;">
                            </div>
                            <!-- </p> -->
                            <div class="input-group mt-2">
                                <button id="proceed" class="mb-2 proceed" style="font-size: 14px; margin-top: 10px;" onclick="return getData()"> Proceed </button>

                            </div>
                        </form>

                    </div>


                    <!-- security question and answer -->
                    <div id="security_question" style="display: none;">
                        <h4 class="mb-4" style="font-weight: bold;">Security Question</h4>
                        <form action="" method="post" id="myform">
                            <div class="alert alert-info">
                                <h4 id="question"> </h4>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" name="security_ans" id="security_ans" placeholder="Enter your Security Answer" class="form-control" style="height: 30px;">
                            </div>
                            <input type="email" id="user-email" value="" hidden>
                            <div class="message1"></div>

                            <!-- confirm button -->
                            <div class="input-group mt-2">
                                <button id="confirm" class="mb-2 proceed" style="font-size: 14px; margin-top: 10px;" onclick="return getData()"> Submit </button>

                            </div>
                        </form>
                    </div>
                    <!-- end of security question and answer -->

                    <!-- password field -->
                    <div id="collage" style="display: none;">
                        <h4>Reset your Password </h4>
                        <div class="message1"></div>
                        <div id="playPanel" style="padding:5px;">
                            <div style="display:inline-block; width:50%; vertical-align:top;">
                                <ul id="sortable" class="sortable"></ul>
                            </div>
                        </div>
                        <!-- confirm button -->
                        <div class="input-group mt-2">
                            <button id="reset_password" class="mb-2 proceed" style="font-size: 14px; margin-top: 10px;"> Reset Password </button>
                        </div>
                        <input type="text" id="puzzle-index" hidden> 
                    </div>
                    <!-- end of password field -->

                    <div id="reset-success" style="display: none;">
                        <h4> Your Password has been reset successfully... click <a href="./login.php">here</a> to login</h4>

                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <img src="img/1612863154426.png" width="600" alt="">
            </div>
        </div>

    </div>

    <script>
        getData = () => {
            return false;
        }
        login = () => {
            $("#proceed").on("click", function(e) {
                let email = $("#username").val();
                if (email == "") {

                    $("#message").html("Please enter your Email address!!!").css({
                        "font-size": "14px",
                        "color": "darkred",
                        "font-weight": "bold"
                    });

                } else {
                    $.ajax({
                        type: "post",
                        url: "app/app.controller.php",
                        data: {
                            action: "verify_user",
                            dataValue: email
                        },
                        dataType: "json",
                        success: function(tx) {

                            if (tx.status == 0) {
                                $("#message").html("Email is not registered!!!").css({
                                    "font-size": "14px",
                                    "color": "darkred",
                                    "font-weight": "bold"

                                });

                            } else if (tx.status == 1) {
                                // let quesion = tx.question;
                                $("#p-reset").hide(() => {
                                    $("#security_question").css({
                                        "display": "block"
                                    });
                                    $("#question").html(tx.question);
                                    $("#user-email").val(tx.user_id);

                                });
                            }
                        }
                    });
                }
            });
            $("#confirm").on("click", function(e) {
                e.preventDefault();

                let answer = $("#security_ans").val().toLowerCase();

                let email = $("#user-email").val();

                const dataValue = [email, answer];
                if (answer == "") {
                    alert("Enter your security answer");
                } else {
                    $.ajax({
                        type: "post",
                        url: "app/app.controller.php",
                        data: {
                            action: "sendAnswer",
                            dataValue: dataValue
                        },
                        dataType: "json",
                        success: function(tx) {

                            if (tx.status == 0) {
                                $(".message1").html("Incorrect Answer!!!").css({
                                    "font-size": "14px",
                                    "color": "darkred",
                                    "font-weight": "bold"

                                });

                            } else if (tx.status == 1) {
                                var images = [{
                                    src: 'puzzleimage/' + tx.picture
                                }];
                                $(function() {

                                    var gridSize = tx.grid_size;
                                    imagePuzzle.startGame(images, gridSize);

                                });
                                $("#collage").show((err) => {
                                    if (err) throw err;
                                    $("#security_question").hide();
                                    $(".message1").html("");
                                });
                            }
                        }
                    });
                }

            });

            $("#reset_password").on("click", function(e) {
                e.preventDefault();
                let email = $("#user-email").val();
                let password = $("#puzzle-index").val();

                console.log([email, password]);
                if (password == "") {
                    alert("Please set the picture Puzzle!!");
                } else {
                    $.ajax({
                        type: "post",
                        url: "app/app.controller.php",
                        data: {
                            action: "resetPassword",
                            user_id: [password, email]
                        },
                        dataType: "json",
                        success: function(tx) {
                            if (tx.response == 0) {
                                $("#collage").hide(() => {
                                    $("#reset-success").show(2000);

                                });

                            } else if (tx.response == 1) {
                                $(".message1").html("An error has occured!!!").css({
                                    "display": "block",
                                    "font-size": "14px",
                                    "color": "darkred"
                                });
                            }
                        }
                    });
                }
            });
        }
        login();
    </script>

</body>

</html>