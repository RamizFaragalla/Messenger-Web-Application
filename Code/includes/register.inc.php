<?php
	
	include "dbconnect.inc.php";


	if(!isset($_POST["register"])) {
		header("Location: ../register.php");
		exit();
	}

	function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}

	$username = test_input($_POST["username"]);
	$password = test_input($_POST["password"]);

	//get users with same username
	$query = "SELECT USER_NAME FROM user ";
	$query .= "WHERE USER_NAME = ?";
	//prepare query
	$stmt = $conn->prepare($query);
	//bind param
	$stmt->bind_param("s", $username);
	//execute
	$stmt->execute();
	//get result
	$result = $stmt->get_result();

	// one of the fields is empty, or both
	if(empty($username) || empty($password)) {
		header("Location: ../register.php?error=emptyfields&username=".$username);
		exit();
	}

    //if email already exists
	else if($result->num_rows == 1){	
			header("Location: ../register.php?error=usernameExists&username=".$username);
			exit();
	} 

	//add user to database
	else {

		$query = "INSERT INTO user(USER_NAME, PASSWORD) VALUES";

		$query .= "(?, ?)";

		// hash the password
		$hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

		//prepare query
		$stmt = $conn->prepare($query);
		//bind param
		$stmt->bind_param("ss", $username, $hashed_pwd);
		//execute
		$stmt->execute();
		

		session_start();
		$_SESSION['username'] = $username;

		header("Location: ../displayHomePage.php");
		exit();
	}
	
?>