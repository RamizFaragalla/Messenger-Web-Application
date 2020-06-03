<?php

	include "dbconnect.inc.php";

	if(isset($_POST["register"])) {
		header("Location: ../register.php");
		exit();
	}

	else if(!isset($_POST["submit"])) {
		header("Location: ../login.php");
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

	// one of the fields is empty, or both
	if(empty($username) || empty($password)) {
		header("Location: ../login.php?error=emptyfields&username=".$username);
		exit();
	}

	else {
		$query = "SELECT USER_NAME, PASSWORD FROM user ";
		$query .= "WHERE USER_NAME like binary ?";
		//prepare query
		$stmt = $conn->prepare($query);
		//bind param
		$stmt->bind_param("s", $username);
		//execute
		$stmt->execute();
		//get result
		$result = $stmt->get_result();

		//if username exists
		if($result->num_rows == 1){
			//get 1 and only row
			$account = $result->fetch_assoc();
			//var_dump($account);
			if(password_verify($password, $account["PASSWORD"])){
				// start a session
				session_start();
				$_SESSION['username'] = $account["USER_NAME"];
				header("Location: ../displayHomePage.php");
				exit();
			} 

			//wrong password
			else{
				header("Location: ../login.php?error=wrongpwd&username=".$username);
				exit();
			}
		} 

		//wrong username
		else{
			header("Location: ../login.php?error=wrongUsername&username=".$username);
			exit();
		}
	}
	
?>