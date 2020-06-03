<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home Page</title>
	
</head>

	<?php
		session_start();
		if (!isset($_SESSION["username"])) {
	  		header("Location: login.php");
	  		exit();
		}
		include "includes/dbconnect.inc.php";

		echo "<p style='color:blue;'>Welcome ".$_SESSION["username"];
	?>
	<a href="includes/logout.inc.php" style="float: right;"> <button style="color:red;">Log Out</button> </a></p>


<style>
	.error{
		color: red;
	}

	* {
		font-family: consolas;
		font-size: 50px;
		background-color: #1b1b1c;
		color: white;
	}

	.button {
		color: green;
	}
</style>
<body>
	<?php
		if(isset($_GET['error'])){
			if($_GET['error'] == 'empty'){
				echo '<p class="error">';
				echo 'Enter a username';
				echo '</p>';

			} else if($_GET['error'] == 'own'){
				echo '<p class="error">';
				echo 'That is your username silly!';
				echo '</p>';
			} else{
				echo '<p class="error">';
				echo 'Username does not exist';
				echo '</p>';
			}
		} 
	?>

	<form action="includes/search.inc.php" method="post">

		<p align = "center">
			<label><input type="text" name="RECIPIENT" size="20" maxlength="40" placeholder="Username" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''?>">
			</label>

			<input type="submit" name="search" value="Search" class="button">
		</p>

	</form>
	<div id="show"></div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script type="text/javascript">
		$('#show').load('homePage.php');
		$(document).ready(function() {
			setInterval(function () {
				$('#show').load('homePage.php')
			}, 1000);
		});

	</script>

</body>
</html>