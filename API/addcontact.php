<?php
	$inData = getRequestInfo();
	
	$first = $inData["first"];
	$last = $inData["last"];
	$email = $inData["email"];
	$phonenumber = $inData["phonenumber"];

	$conn = new mysqli("localhost", "francis", "", "contactmanager");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$sql = "insert into contactlist (first,last,email,phonenumber) VALUES ('$first','$last','$email',
																			   '$phonenumber')";
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		$conn->close();
	}
	
	returnWithError("");
	
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
