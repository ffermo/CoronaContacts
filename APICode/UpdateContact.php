<?php
	$inData = getRequestInfo();
	
	// Parse and store individuals fields from JSON field into variables.
	$name = $inData["name"];
	$email = $inData["email"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];
	$phone = $inData["phone"];
	$infected = $inData["infected"];
	$ID = $inData["ID"];
	$userId = $inData["userId"];

	// Establish a connection to the backend.
	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");
	
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	
	else 
	{
		// To update info already in the table in the database.
		$sql = "UPDATE Contacts SET 
		Name = '$name', 
		Email = '$email', 
		City = '$city', 
		State = '$state', 
		Zip = '$zip', 
		Phone = '$phone', 
		Infected = '$infected' 

		WHERE ID = '$ID'";

		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		
		$conn->close();
	}
	
	// If it reaches here, contact is updated in the database.
	returnWithError("CONTACT UPDATED!");
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
