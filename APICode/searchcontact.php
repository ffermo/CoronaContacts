<?php

	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;

	$name = $inData["name"];
	$email = $inData["email"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];
	$phone = $inData["phone"];
	$infected = $inData["infected"];
	$userId = $inData["userId"];

	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		// $sql = "SELECT contact_id, first_name, last_name, email, phone_number, user_id FROM list_of_contacts WHERE (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%') AND user_id = $userId ORDER BY $filter"; 

		$sql = "SELECT * FROM Contacts WHERE ((name LIKE '%$search%') OR (email LIKE '%$search%') OR (city LIKE '%$search%') OR (state LIKE '%$search%') OR (zip LIKE '%$search%') OR (phone LIKE '%$search%')) AND user_id = $userId ORDER BY $filter";

		// $sql = "select * from Contacts where Name like '%" . $inData["search"] . "%' and UserID=" . $inData["userId"];
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				if( $searchCount > 0 )
				{
					$searchResults .= ",";
				}
				
				$searchCount++;
				
				$searchResults .= '"'$row["name", "email", "phone"]'"';
			}
		}
		
		else
		{
			returnWithError( "No Records Found" );
		}
		
		$conn->close();
	}

	returnWithInfo( $searchResults );

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
		$retValue = '{"BOB DID IT!"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>