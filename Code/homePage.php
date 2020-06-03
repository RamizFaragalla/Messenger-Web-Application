<?php
	session_start();
	if (!isset($_SESSION["username"])) {
  		header("Location: login.php");
  		exit();
	}


	include "includes/dbconnect.inc.php";

?>
<html>
	<style>
		.error{
			color: red;
		}
		* {
			font-family: consolas;
			font-size: 25px;
			background-color: #1b1b1c;
			color: white;
		}


	</style>

	<Label>Conversations: 

	<?php
		$query = "SELECT u1.USER_NAME AS u1, u2.USER_NAME AS u2";
		$query .= " FROM message m";
		$query .= " JOIN user u1";
		$query .= " ON m.SENDER_ID = u1.USER_ID";
		$query .= " JOIN user u2";
		$query .= " ON m.RECIPIENT_ID = u2.USER_ID";
		$query .= " WHERE u1.USER_NAME = ? || u2.USER_NAME = ?";
					
		$stmt = $conn->prepare($query);

		//binding parameter
		$stmt->bind_param("ss", $_SESSION["username"], $_SESSION["username"]);

		//execute query
		$stmt->execute();

		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		if(!$result)
			echo "0"."</p>";

		else {
			$visited = array();
			$count = 0;
		    foreach ($result as $row){
				if($row["u1"] == $_SESSION["username"]) {
					if(in_array($row["u2"], $visited))
						continue;
					else {
						$count++;
						array_push($visited, $row["u2"]);
					}
				}

				else {
					if(in_array($row["u1"], $visited))
						continue;
					else {
						$count++;
						array_push($visited, $row["u1"]);
					}
				}
		    }
		    echo $count."</Label><br>";
		}
	?>
	<br>

	<body>
		<?php
			$query = "SELECT m.DATE, u1.USER_NAME AS u1, u2.USER_NAME AS u2";
			$query .= " FROM message m";
			$query .= " JOIN user u1";
			$query .= " ON m.SENDER_ID = u1.USER_ID";
			$query .= " JOIN user u2";
			$query .= " ON m.RECIPIENT_ID = u2.USER_ID";
			$query .= " WHERE u1.USER_NAME = ? || u2.USER_NAME = ?";
			$query .= " ORDER BY DATE DESC";

						
			$stmt = $conn->prepare($query);

			//binding parameter
			$stmt->bind_param("ss", $_SESSION["username"], $_SESSION["username"]);

			//execute query
			$stmt->execute();

			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

			if(!$result)
				echo "No messages";

			else {
				$visited = array();
			    foreach ($result as $row){
					if($row["u1"] == $_SESSION["username"]) {
						if(in_array($row["u2"], $visited))
							continue;
						else {
							echo $row["u2"];
							array_push($visited, $row["u2"]);
							$link = "displayMessages.php?username=".$row["u2"];
							$link2 = "includes/delete.inc.php?username=".$row["u2"];
						}
					}

					else {
						if(in_array($row["u1"], $visited))
							continue;
						else {
							echo $row["u1"];
							array_push($visited, $row["u1"]);
							$link = "displayMessages.php?username=".$row["u1"];
							$link2 = "includes/delete.inc.php?username=".$row["u1"];
						}
					}
				
					echo '<a href='.$link2.' style="float: right;"><button style="color:red;">delete</button></a>';
					echo ' <a href='.$link.' style="float: right;"><button style="color:blue;">message</button></a><br><br>';	
					
					//echo "<br><br><hr><br>";
			    }
			}
		?>
	</body>
</html>