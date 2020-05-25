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

	// checking if the connection was successful or not
	if ($conn->connect_error) 
	{
		// if the connection was not successfull return an error 
		returnWithError( $conn->connect_error );
	} 

	// if the connection was successful 
	else
	{
		// using sql to store the data fields into the database.
		$sql = "insert into Contacts (Name, Email, City, State, Zip, Phone, Infected, UserId) VALUES ('$name','$email','$city','$state','$zip','$phone', '$infected', '$userId')";
		
		// ???
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		
		// closing the connection with the localhost
		$conn->close();
	}
	
	// basically depicts that our API works
	returnWithError("CONTACT CREATED!");
	
	// function to get info from the user
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}
	// function for ???
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	// function that returns error messages
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>