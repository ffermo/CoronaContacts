<?php
	$inData = getRequestInfo(); // Store contents from JSON file into variable.
	
	// Parse and store individuals fields from JSON field into variables.
	$firstName = $inData["first"];
	$lastName = $inData["last"];
	$email = $inData["email"];
	$password = $inData["password"];

	$conn = new mysqli("localhost", "ubuntu", "", "coronacontacts"); // Establishes connection to local SQL database.

	if ($conn->connect_error) // If there's a connection error to SQL database, returns error message.
	{
		returnWithError( $conn->connect_error );
	} 
	else // If there's no connection error, proceed with inserting values into SQL data table titled "contactlist".
	{
		$sql = "SELECT * FROM Users WHERE Email='$email'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$id = 0;
			$firstName = "";
			$lastName = "";

			returnWithInfo($id, $firstName, $lastName);
		}

		else
		{
			$sql = "INSERT INTO Users (FirstName,LastName,Email,Password) VALUES ('$firstName','$lastName','$email','$password')";

			if( $result = $conn->query($sql) != TRUE ) // Return error if there's issue with inserting values.
			{
				returnWithError( $conn->error ); 
			}

			$sql = "SELECT * FROM Users WHERE Email='$email'";
			$result = $conn->query($sql);

			if ($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				$firstName = $row["FirstName"];
				$lastName = $row["LastName"];
				$id = $row["ID"];
			}

			returnWithInfo($id, $firstName, $lastName);
		}
	}

	$conn->close();

	
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

	function returnWithInfo($id,$firstName, $lastName)
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue  );
	}
?>
