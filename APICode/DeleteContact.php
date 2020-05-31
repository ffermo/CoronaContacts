<?php
	$inData = getRequestInfo();
	// $ID = getID();

	// $searchResults = "";
	// NOTE: Variables (might change later)
	// Parse and store individuals fields from JSON field into variables.
	$ID = $inData["ID"];
	$userId = $inData["userId"];
	// establishing connection to localhost
	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");
	// returning an error if the connection was not successfull
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		// UserID included just to make sure you can't delete someone else's contacts
		$sql = "DELETE FROM Contacts WHERE ID = '" . $ID . "'" . "AND UserID ='" . $userId . "'";
		
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		
		$conn->close();
	}
	// Confirms that the API works
	returnWithError("CONTACT DELETED!");
	
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