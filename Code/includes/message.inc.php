<?php

	include "dbconnect.inc.php";
	session_start();

	// illegal access
	if(!isset($_POST["send"]) && !isset($_POST["back"])) {
		header("Location: ../logout.inc.php");
		exit();
	}

	else if(isset($_POST["back"])) {
		header("Location: ../displayHomePage.php");
		exit();
	}

	function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}

	$content = test_input($_POST["message"]);

	$noContent = empty($content) && $_FILES["file"]["error"] == UPLOAD_ERR_NO_FILE;
	// one of the fields is empty, or both
	if($noContent) {
		//echo $title;
		header("Location: ../displayMessages.php?username=".$_SESSION["RECIPIENT"]);
		exit();
	}

	// if update is pressed, update every attribute
	else {
		if(empty($content)) {
			$target_dir = "photos/";
			$target_file = $target_dir.basename($_FILES["file"]["name"]);
			$file_type = pathinfo($target_file,PATHINFO_EXTENSION);
			$accepted = array("jpg", "JPG", "png", "PNG", "gif");

			// txt
			if($file_type == "txt") {
				move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
				$content = file_get_contents($target_file);
				$content = test_input($content); // sanatize input
				unlink($target_file);	// ***delete the file once it's copied into $content variable
			}

			// picture
			else if(in_array($file_type, $accepted)) {
				move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
				$content = $target_file;
			}

			else {
				header("Location: ../displayMessages.php?username=".$_SESSION["RECIPIENT"]);
				exit();
			}
			
		}

		// get SENDER_ID
		$query = "SELECT USER_ID FROM user WHERE USER_NAME = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $_SESSION["username"]);
		$stmt->execute();

		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$sID = $result[0]["USER_ID"];

		// get RECIPIENT_ID
		$query = "SELECT USER_ID FROM user WHERE USER_NAME = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $_SESSION["RECIPIENT"]);
		$stmt->execute();

		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$rID = $result[0]["USER_ID"];

		// insert new message 
		$query = "INSERT INTO message (CONTENT, SENDER_ID, RECIPIENT_ID, DATE)";
		$query .= " VALUES (?, ?, ?, NOW())";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("sii", $content, $sID, $rID);
		$stmt->execute();
		
		header("Location: ../displayMessages.php?username=".$_SESSION["RECIPIENT"]);
		exit();
	}
?>