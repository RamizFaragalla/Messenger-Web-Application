<?php
	if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { 
		die(header("Location: logout.inc.php")); 
	}
	//reporting query and code errors based on flags set
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	//use try/catch blog for exception handling.
	try {
		//create a connection with mysqli($domain, $username, $password, $database)
		$conn = new mysqli("localhost", "root", "", "messenger");
		//$conn = new mysqli("163.238.35.165", "faragalla", "ramiz8375", "faragalla_csc226");
		//avoid weird issues with strings in database
		$conn->set_charset("utf8mb4");
	} catch(Exception $e) {
		//log error into a file on server
		error_log($e->getMessage());
		exit('Error connecting to database'); //easy message for clients
	}
?>
