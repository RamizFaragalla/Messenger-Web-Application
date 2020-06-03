<?php
	session_start();
	if (!isset($_SESSION["username"])) {
  		header("Location: login.php");
  		exit();
	}


	include "includes/dbconnect.inc.php";
	
?>
<html>
	<head>
		<title>Message</title>
	</head>
		<?php
			//include "includes/header.php";
		?>
	
	<style>

		* {
			font-family: consolas;
			font-size: 20px;
			background-color: #1b1b1c;
			color: white;
		}

	</style>

	<script type="text/javascript">
	</script>

	<body>
		<?php

			$query = "SELECT m.CONTENT, m.DATE, u1.USER_NAME AS u1, u2.USER_NAME AS u2";
			$query .= " FROM message m";
			$query .= " JOIN user u1";
			$query .= " ON m.SENDER_ID = u1.USER_ID";
			$query .= " JOIN user u2";
			$query .= " ON m.RECIPIENT_ID = u2.USER_ID";
			$query .= " WHERE (u1.USER_NAME = ? && u2.USER_NAME = ?)";
			$query .= " || (u1.USER_NAME = ? && u2.USER_NAME = ?)";
			$query .= " ORDER BY DATE ASC";

				
			$stmt = $conn->prepare($query);

			//binding parameter
			$stmt->bind_param("ssss", $_SESSION["username"], $_SESSION["RECIPIENT"], $_SESSION["RECIPIENT"], $_SESSION["username"]);

			//execute query
			$stmt->execute();

			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

			
			if($result) {
			    foreach ($result as $row){
			    	// user logged in is the sender
					if($row["u1"] == $_SESSION["username"]) {
						echo "<p style='color:blue;'>";
					}

					// other user is the sender
					else {
						echo "<p style='color:red;'>";
						echo $_SESSION["RECIPIENT"].": ";
					}

					$file_type = pathinfo($row["CONTENT"],PATHINFO_EXTENSION);
					$accepted = array("jpg", "JPG", "png", "PNG", "gif");
					if(in_array($file_type, $accepted)) {
						$link = "includes/displayImage.inc.php?link=".$row["CONTENT"];
						if($row["u1"] != $_SESSION["username"])
							echo "<br>";
						echo "<a href=".$link.">
						<img src=includes/".$row["CONTENT"]."
						style='width:150px;height:150px;'></a><br>";
					}
					else
						echo $row["CONTENT"]."<br>";

					echo $row["DATE"];
					echo "</p>";
					//echo "<hr>";
			    }
			}

		?>

	</body>
</html>