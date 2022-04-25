<?php

	// remove next two lines for production

	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);

	$executionStartTime = microtime(true);

	include("config.php");

	header('Content-Type: application/json; charset=UTF-8');

	$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

	if (mysqli_connect_errno()) {
		
		$output['status']['code'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "database unavailable";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output);

		exit;

	}
    $id = $_POST['id'];

	$stmt = $conn->prepare('SELECT * from department where locationID = ?');
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$result = $stmt->get_result();


	if(mysqli_num_rows($result) > 0)
	{
		$output['status']['code'] = "202";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "Staff assigned to this department";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	}
	else {
	
		$output['status']['code'] = "200";
		$output['status']['name'] = "ok";
		$output['status']['description'] = "success";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];
	}
	
	mysqli_close($conn);

	echo json_encode($output); 

?>