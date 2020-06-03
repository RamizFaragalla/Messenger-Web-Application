<style>
	* {
		font-family: consolas;
		font-size: 20px;
		background-color: #1b1b1c;
		color: white;
	}
</style>
<?php
	session_start();
	if (!isset($_SESSION["username"])) {
  		header("Location: login.php");
  		exit();
	}
	$link = "../displayMessages.php?username=".$_SESSION["RECIPIENT"];
	echo "<a href=".$link."> <button style='color:green;'>Back</button> </a>";

	echo "<br><br><br><br>";

	echo "<img src=".$_GET["link"]."></a>"
?>
