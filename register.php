<?php

include_once("app/app.connect.php");
// @session_start();
// $st = new dbconnect;
// $conn = $st->connection();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Puzzle Authentication </title>

    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
    <link href="css/style.css" rel="stylesheet" />
    <!-- <link href="css/image-puzzle.css" rel="stylesheet" /> -->
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
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="alert nav-alert text-center">
            <a href="index.php" style="float: left;text-decoration: none;color: yellowgreen;font-size: 25px;">Home</a>

            Web-based Puzzle lock Authentication System
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="jumbotron">
                    <div id="reg-panel">
                        <h3 style="text-align: center;">Register now</h3>
                        <form action="" method="post" id="myform" enctype="multipart/form-data">
                            <p id="panel-main">
                            <div class="input-group mb-2">
                                <label for="Fullname" style="font-size:14px;"> Full name &nbsp;</label>
                                <input type="text" name="fullname" id="fullname" class="form-control" style="height: 25px;">
                            </div>

                            <!-- <div class="input-group mb-2">
                                <label for="username" style="font-size:14px;">Username&nbsp;</label>
                                <input type="text" name="username" id="username" disabled class="form-control" style="height: 25px;">
                            </div> -->

                            <div class="input-group mb-2">
                                <label for="email" style="font-size:14px;"> Email &nbsp;</label>
                                <input type="email" name="email" id="email" disabled class="form-control" style="height: 25px;">
                            </div>

                            <div class="input-group mb-2">
                                <label for="username" style="font-size:14px;">Select Puzzle pattern &nbsp;</label>
                                <select name="" id="puzzle_pattern" class="form-control" style="height: 30px;font-size: 12px;" disabled>
                                    <option value="">Select Option</option>
                                    <option value="2">2x2</option>
                                    <option value="3">3x3</option>
                                </select>
                            </div>

                            <div class="input-group mt-2">
                                <label for="picture" style="font-size:14px;"> Select a picture you would like to use </label>
                                <input type="file" id="chosefile" style="font-size: 14px;" disabled accept=".jpg, .jpeg, .png">
                            </div>
                            </p>
                            <div id="collage" style="display: none;">
                                <div id="playPanel" style="padding:5px;">
                                    <div style="display:inline-block; width:50%; vertical-align:top;">
                                        <ul id="sortable" class="sortable"></ul>
                                    </div>
                                </div>

                            </div>
                            <div class="input-group mt-2">
                                <button id="reg" class="mb-2" style="font-size: 14px;" onclick="return getData()" disabled> Register </button>

                            </div>
                            <a href="login.php" style="float: right;text-decoration: none;color: yellowgreen;font-size: 16px;font-weight: bold;">Click here to Login</a>

                            <input type="text" id="puzzle-index" hidden>
                        </form>
                    </div>




                </div>
            </div>

            <div class="col-md-6">
                <img src="img/1612863154426.png" width="600" alt="">


            </div>
        </div>
        <div>
        </div>

        <!-- <div class="alert footer-alert"></div>
            </div> -->

        <script>
            getData = () => {
                return false;
            }
            register = () => {
                $("#fullname").on("blur", function(e) {

                    if ($(this).val() !== "") {
                        $("#email").attr("disabled", false);

                    }
                });
                // $("#username").on("blur", function(e) {

                //     if ($(this).val() !== "") {
                //         $("#email").attr("disabled", false);

                //     }
                // });
                $("#email").on("blur", function(e) {

                    if ($(this).val() !== "") {
                        $("#puzzle_pattern").attr("disabled", false);

                    }
                });

                const option = () => {
                    $("#puzzle_pattern").on("change", function(e) {
                        if ($(this).val() !== "") {
                            $("#chosefile").attr("disabled", false);

                        }
                    });
                }
                option();

                $("#chosefile").on("change", function() {

                    var fd = new FormData();
                    var files = $(this)[0].files[0];
                    $("#reg").attr("disabled", false);

                    fd.append('file', files);
                    let fullpathname = $(this).val();
                    var splt = fullpathname.split("\\");
                    let realfilename = splt[2];

                    var images = [{
                            src: 'puzzleimage/' + realfilename
                        }

                    ];
                    $(function() {

                        var gridSize = $("#puzzle_pattern").val();

                        imagePuzzle.startGame(images, gridSize);

                    });

                    $.ajax({
                        type: "post",
                        url: "app/try.php",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(Response) {
                            if (Response == 0) {
                                $("#collage").show();

                            }
                        }
                    });

                });

                $("#reg").on("click", function(e) {

                    let fullname = $("#fullname").val();
                    // let username = $("#username").val();
                    let puzzle_index = $("#puzzle-index").val();
                    let gridSize = $("#puzzle_pattern").val();
                    let email = $("#email").val();

                    let fullpathname = $("#chosefile").val();
                    let splt = fullpathname.split("\\");
                    let realfilename = splt[2];

                    const sendData = [fullname, puzzle_index, realfilename, gridSize, email];

                    if (puzzle_index == "") alert("Please set the picture Puzzle");

                    else {
                        $.ajax({
                            url: "app/app.controller.php",
                            type: "post",
                            data: {
                                action: "registerUser",
                                dataValue: sendData
                            },
                            dataType: "json",
                            success: function(tx) {
                                if (tx.response == 1) {
                                    // alert("Registration is Successful");
                                    $("#reg-panel").fadeOut(() => {
                                        window.location = "./security.php";

                                    });
                                    //window.location = "./application.php";
                                } else if (tx.response == 0) alert("Email already taken!!!");

                            }

                        });

                    }

                });

            }
            register()
        </script>

</body>

</html>