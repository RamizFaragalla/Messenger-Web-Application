<?php
	include "dbconnect.inc.php";
	session_start();

	// illegal access for security
	if(!isset($_POST["search"])) {
		header("Location: logout.inc.php");
		exit();
	}


	function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}

	$username = test_input($_POST["RECIPIENT"]);

	// empty field
	if(empty($username)) {
		//echo $title;
		header("Location: ../displayHomePage.php?error=empty&username=".$username);
		exit();
	}

	// your username
	else if($username == $_SESSION["username"]) {
		header("Location: ../displayHomePage.php?error=own&username=".$username);
		exit();
	}

	// does not exist
	else {
		$query = "SELECT USER_NAME FROM user";
		$query .= " WHERE USER_NAME like binary ?";
		//prepare query
		$stmt = $conn->prepare($query);
		//bind param
		$stmt->bind_param("s", $username);
		//execute
		$stmt->execute();
		//get result
		$result = $stmt->get_result();

		//if username doesn't exists
		if($result->num_rows != 1) {
			header("Location: ../displayHomePage.php?error=dne&username=".$username);
			exit();
		}

		// exists
		else {
			header("Location: ../displayMessages.php?username=".$username);
			exit();
		}
	}
?>