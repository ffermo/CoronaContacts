<?php
	// PHP file for login API
	// collects data from the user in the input box
	$inData = getRequestInfo();
	
	// Parse and store individuals fields from JSON field into variables.
	$email = $inData["email"];
	$password = $inData["password"];

	// connecting to the server
	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");

	// checking if the connection was successful
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	}

	// collecting password and emails for login if the connection was successful
	else
	{
		$sql = "SELECT * FROM Users WHERE Password='$password' AND Email='$email'";
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$firstName .= $row["FirstName"];
			$lastName .= $row["LastName"];
			$id .= $row["ID"];
			
			returnWithInfo($firstName, $lastName, $id);
		}
		
		else
		{
			$email = '';
			$password = '';
			$id = 0;

			returnWithInfo($firstName, $lastName, $id );
		}
		
		$conn->close();
	}

	// function that requests data from the user (JSON)
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
	
	// function return the required info as needed.
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
