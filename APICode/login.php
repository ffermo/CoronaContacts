<?php

	$inData = getRequestInfo();
	
	$email = $inData["email"];
	$password = $inData["password"];

	$conn = new mysqli("localhost", "ubuntu", "", "coronacontacts");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	}

	else
	{
		$sql = "SELECT email FROM Users where Password='" . $inData["password"] . "'";
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$email = $row["email"];
			$passsord = $row["password"];
			// $id = $row["ID"];
			
			// returnWithInfo($firstName, $lastName, $id );
		}
		
		else
		{
			returnWithError( "No Records Found" );
		}
		
		$conn->close();
	}

	returnWithError("Login Complete");
	
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
		$retValue = '{"'. $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	// function returnWithInfo( $firstName, $lastName, $id )
	// {
	//	$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . //'","lastName":"' . $lastName . '","error":""}';
	//	sendResultInfoAsJson( $retValue );
	// }
	
?>