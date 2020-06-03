<?php
	session_start();
	if (!isset($_SESSION["username"])) {
  		header("Location: login.php");
  		exit();
	}

	if(!isset($_GET["username"])) {
		header("Location: ../displayHomePage.php");
  		exit();
	}

	include "dbconnect.inc.php";

?>
<html>
	<style>
		* {
			font-family: consolas;
			font-size: 15px;
		}
	</style>

	<body>
		<?php
			// find ids
			// get ID of person logged in
			$query = "SELECT USER_ID FROM user WHERE USER_NAME = ?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $_SESSION["username"]);
			$stmt->execute();

			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$ID1 = $result[0]["USER_ID"];

			// get other ID
			$query = "SELECT USER_ID FROM user WHERE USER_NAME = ?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $_GET["username"]);
			$stmt->execute();

			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$ID2 = $result[0]["USER_ID"];

			$query = "DELETE FROM message";
			$query .= " WHERE (SENDER_ID = ? && RECIPIENT_ID = ?)";
			$query .= " || (SENDER_ID = ? && RECIPIENT_ID = ?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssss", $ID1, $ID2, $ID2, $ID1);
			$stmt->execute();

			header("Location: ../displayHomePage.php");
			exit();

		?>
	</body>
</html>