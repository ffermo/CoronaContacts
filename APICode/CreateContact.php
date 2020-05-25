<?php
	// requesting users input
	$inData = getRequestInfo();
	
	// defining all the required fields for the contacts
	$name = $inData["name"];
	$email = $inData["email"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];
	$phone = $inData["phone"];
	$infected = $inData["infected"];
	$userId = $inData["userId"];

	// connecting to the localhost
	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		$sql = "insert into Contacts (Name, Email, City, State, Zip, Phone, Infected, UserId) VALUES ('$name','$email','$city','$state','$zip','$phone', '$infected', '$userId')";
		
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		
		$conn->close();
	}
	
	returnWithError("CONTACT CREATED!");
	
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