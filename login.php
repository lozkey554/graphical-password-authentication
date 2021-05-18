<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Puzzle Authentication</title>
	<link href="css/style.css" rel="stylesheet" />
	<link href="css/css/bootstrap.min.css" rel="stylesheet" />

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
			<a href="index.php" style="float: left;text-decoration: none;color: yellowgreen;font-size: 25px;"> Home </a>
			Web-based Puzzle lock Authentication System
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="jumbotron">
					<h3 style="text-align: center;">Login now</h3>
					<p id="message"></p>
					<form action="" method="post" id="myform" enctype="multipart/form-data">
						<p id="panel-main">
						<div class="input-group mb-2">
							<label for="username" style="font-size:14px;">Username&nbsp;</label>
							<input type="text" name="username" id="username" class="form-control" style="height: 30px;">
						</div>

						</p>
						<p id="message1"></p>

						<div id="collage" style="display: none;">
							<div id="playPanel" style="padding:5px;">
								<div style="display:inline-block; width:50%; vertical-align:top;">
									<ul id="sortable" class="sortable"></ul>
								</div>
							</div>

						</div>
						<a href="fget.php" id="reset"> Forget Password? </a> or <a href="./register.php" style="font-size: 14px;color: yellowgreen"> Click here to Register </a>
						<div class="input-group mt-2">
							<button id="proceed" class="mb-2 proceed" style="font-size: 14px; margin-top: 10px;" onclick="return getData()" disabled> Proceed </button>
							<button id="login" class="mb-2" style="font-size: 14px;display:none" onclick="return getData()"> Login </button>
						</div>

						<input type="text" id="puzzle-index" hidden>

					</form>
				</div>
			</div>


			<div class="col-md-6">
				<img src="img/1612863154426.png" width="600" alt="">


			</div>

		</div>

		<div class="alert footer-alert"></div>
	</div>

	<script>
		getData = () => {
			return false;
		}
		login = () => {
			$("#proceed").on("click", function(e) {
				let username = $("#username").val();
				if (username == "") alert("Please enter your username!!!");
				else {
					$.ajax({
						type: "post",
						url: "app/app.controller.php",
						data: {
							action: "showPassword",
							dataValue: username
						},
						dataType: "json",

						success: function(tx) {
							if (tx.status == 2){ window.location = "./security.php";}

							else if(tx.status == 1) {

								var images = [{
									src: 'puzzleimage/' + tx.picture
								}];
								$(function() {

									var gridSize = tx.grid_size;
									imagePuzzle.startGame(images, gridSize);

								});
								$("#collage").show(function() {
									$("#proceed").hide(function() {
										$("#login").css("display", "block");
										$("#message").hide();
									});

								});

							} else {
								$("#message").html("Username is not registered!!!").css({
									"font-size": "14px",
									"color": "darkred"
								});
							}
						}
					});
				}
			});
			$("#username").on("blur", function(e) {

				if ($(this).val() == "") alert("Please enter your username!!!");
				else $("#proceed").attr("disabled", false);

			});

			$("#login").on("click", function() {

				let password = $("#puzzle-index").val();
				let username = $("#username").val();

				if (password == "") alert("Please set the picture Puzzle!!");
				else {
					$.ajax({
						type: "post",
						url: "app/app.controller.php",
						data: {
							action: "loginUser",
							user_id: [password, username]
						},
						dataType: "json",
						success: function(tx) {
							if (tx.response == 0) {
								window.location = "./application.php";
							} else if (tx.response == 1) {
								$("#message1").html("Password is not correct!!!").css({
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
		login()
	</script>

</body>

</html>