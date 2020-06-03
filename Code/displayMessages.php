<!DOCTYPE html>
<html>
<head>
	<style>
		div.sticky {
			position: fixed;
			top: 89%;
		}

		div.sticky2 {
			position: sticky;
			top: 0;
		}

		* {
			font-family: consolas;
			font-size: 20px;
			background-color: #1b1b1c;
			color: white;
		}

		.button {
			color: green;
		}


	</style>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Message</title>

</head>
	<?php
		include "includes/dbconnect.inc.php";
		session_start();
		if (!isset($_SESSION["username"])) {
	  		header("Location: login.php");
	  		exit();
		}

		if(!isset($_GET["username"])) {
			header("Location: displayHomePage.php");
	  		exit();
		}

		$query = "SELECT USER_NAME FROM user";
		$query .= " WHERE USER_NAME like binary ?";
		//prepare query
		$stmt = $conn->prepare($query);
		//bind param
		$stmt->bind_param("s", $_GET["username"]);
		//execute
		$stmt->execute();
		//get result
		$result = $stmt->get_result();

		//if username doesn't exists
		if($result->num_rows != 1) {
			header("Location: displayHomePage.php?error=dne");
			exit();
		}
	?>

<body>
<div class="sticky2">
	<?php
		$_SESSION["RECIPIENT"] = $_GET["username"];
		echo "<br><p style='color:red;'>".$_SESSION["RECIPIENT"];
	?>
	<a href="includes/logout.inc.php" style="float: right;"> <button style="color:red;">Log Out</button> </a></p><br>
</div>

	<div id="show"></div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script type="text/javascript">
		$('#show').load('message.php?');
		$(document).ready(function() {
			window.scrollTo(0,document.body.scrollHeight);
			var orig = $(document).height();
			setInterval(function () {
				$('#show').load('message.php?')
				var curr = $(document).height();
				if(curr > orig) {
					window.scrollTo(0,document.body.scrollHeight);
					orig = $(document).height();
				}
			}, 1000);

		});

	</script>

	<form action="includes/message.inc.php" method="post" enctype="multipart/form-data">
		<br><br>
	
		<p align = "left">
		<div class="sticky">
			<textarea name="message" size="27" rows="1" cols="25" placeholder="Text Message" value=""></textarea>
			<input type="submit" name="send" value="Send" class="button">
			<input type="submit" name ="back" value="Back" class="button">
			<input type="file" name="file"> 
		</div>
		</p>
	
	</form>

</body>
</html>