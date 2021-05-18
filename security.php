<?php

// include_once("app/app.controller.php");
include_once("app/app.connect.php");
session_start();
// $st = new dbconnect;
// $conn = $st->connection();

// if (isset($_SESSION["user_id"])) {
//     $email = $_SESSION["user_id"];

//     $query = $conn->query("SELECT * FROM user_account WHERE `email` = '$email'") or die(mysqli_error($conn));
//     $row = mysqli_fetch_assoc($query);
//     $status = $row["status"];

//     if (isset($email) && $status == 0) {
//         header("location: ./register.php");
//     }
// }

// // session_destroy();

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

                    <!-- security questions -->
                    <div id="sec-panel">
                        <div class="alert alert-primary" style="font-size:14px;"> Select Security Question & Answers for Password recovery</div>
                        <form action="/register.php" method="post">

                            <div class="input-group mb-3">
                                <select name="" class="form-control" id="security" required>
                                    <option value="" selected disabled> -- Select Question --</option>
                                    <option value="What is the name of your favorite childhood friend?"> What is the name of your favorite childhood friend? </option>
                                    <option value="Where were you when you had your first kiss?">Where were you when you had your first kiss?</option>
                                    <option value="What is the first name of the boy or girl that you first kissed?"> What is the first name of the boy or girl that you first kissed?</option>
                                    <option value="In what year was your mother born?">In what year was your mother born?</option>
                                    <option value="What is the title of your favorite song?">What is the title of your favorite song?</option>
                                    <option value="What is the title of your favorite book?">What is the title of your favorite book?</option>
                                    <option value="In what city were you born?">In what city were you born?</option>
                                    <option value="What was the first movie you saw in the theater?">Wha was the first movie you saw in the theater?</option>
                                    <option value="Where did you meet your Spouse?">Where did you meet your Spouse?</option>
                                    <option value="What was your grandfather`s occupation?">What was your grandfather`s occupation?</option>
                                    <option value="What was your grandmother`s occupation?">What was your grandmother`s occupation?</option>
                                </select>
                            </div>
                            <input type="text" value="<?php echo $_SESSION['user_id']; ?>" id="email">
                            <input type="text" class="form-control" placeholder="Security Answer" aria-label="Security Answer" aria-describedby="basic-addon1" id="answer" required>
                            <div class="message"></div>
                            <div class="input-group mt-4">
                                <button class="btn btn-block" id="submit" style="background-color:#FF7043"> Submit</button>
                            </div>
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
            $(document).ready(function() {

                $("#submit").on("click", function(e) {

                    let question = $("#security").val();

                    let answer = $("#answer").val();
                    let email = $("#email").val();

                    const sendData = [question, answer, email];

                    if (question == "" || answer == "") {
                        $(".message").html("Please enter your security question and answer...");
                    } else {
                        $.ajax({
                            url: "app/app.controller.php",
                            type: "post",
                            data: {
                                action: "setRecovery",
                                dataValue: sendData
                            },
                            dataType: "json",
                            success: function(tx) {
                                if (tx.response == 1) {
                                    window.location = "./application.php";
                                } else if (tx.response == 0) alert("An error has occured!");

                            }

                        });

                    }

                });
            });
        </script>

</body>

</html>