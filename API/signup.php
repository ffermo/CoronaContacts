<?php
	$inData = getRequestInfo(); // Store contents from JSON file into variable.
	
	// Parse and store individuals fields from JSON field into variables.
	$first = $inData["first"];
	$last = $inData["last"];
	$email = $inData["email"];

	$conn = new mysqli("localhost", "francis", "", "contactmanager"); // Establishes connection to local SQL database.

	if ($conn->connect_error) // If there's a connection error to SQL database, returns error message.
	{
		returnWithError( $conn->connect_error );
	} 
	else // If there's no connection error, proceed with inserting values into SQL data table titled "contactlist".
	{
		// TODO Change this line once USER database has been created.
		$sql = "insert into contactlist (first,last,email,phonenumber) VALUES ('$first','$last','$email',
																			   '$phonenumber')";
		if( $result = $conn->query($sql) != TRUE ) // Return error if there's issue with inserting values.
		{
			returnWithError( $conn->error ); 
		}
		$conn->close();
	}
	
	returnWithError("Registered user!"); // Reaches this statement if everything worked.
	
	function getRequestInfo() // Function to return contents from JSON file.
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
		$retValue = '{"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
