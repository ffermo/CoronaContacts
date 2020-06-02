<?php

	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;

	// Contacts: name, email, city, state, zip, phone

	// Parse and store individuals fields from JSON field into variables.
	// $name = $inData["name"];
	// $email = $inData["email"];
	// $city = $inData["city"];
	// $state = $inData["state"];
	// $zip = $inData["zip"];
	// $phone = $inData["phone"];
	// $infected = $inData["infected"];
	
	$userId = $inData["userId"];

	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$sql = "SELECT * FROM Contacts WHERE 
		(
		Name LIKE '%" . $inData["search"] . "%' OR 
		Email LIKE '%" . $inData["search"] . "%' OR 
		City LIKE '%" . $inData["search"] . "%' OR 
		State LIKE '%" . $inData["search"] . "%' OR 
		Zip LIKE '%" . $inData["search"] . "%' OR 
		Infected LIKE '%" . $inData["search"] . "%' OR
		Phone LIKE '%" . $inData["search"] . "%'
		)
		AND UserID =" . $inData["userId"];


		$result = $conn->query($sql);

		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				if( $searchCount > 0 )
				{
					$searchResults .= ",\n";
				}

				$searchCount++;

				$date = new DateTime($row["DateContactCreated"] ." UTC");
				$date->setTimezone(new DateTimeZone('America/New_York'));
				$formattedDate = date_format($date, 'm/d/Y');

				$searchResults .= '{
				"id":"' . $row["ID"] . '",
				"datecontactcreated":"' . $formattedDate . '",
				"name":"' . $row["Name"] . '",
				"email":"' . $row["Email"] . '",
				"city":"' . $row["City"] . '",
				"state":"' . $row["State"] . '",
				"zip":"' . $row["Zip"] . '",
				"phoneNumber":"' . $row["Phone"] . '",
				"infected":"' . $row["Infected"] . '",
				"userID":"'. $row["UserID"].'"
				}' ;
				
				// Note for Reference: return all value and we do not have to show them all.
			}

			returnWithInfo( $searchResults );
		}

		else
		{
			$err = "No results found";
			returnWithError($err);
		}
		$conn->close();
	}


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
		$retValue = '{"id":-1,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
