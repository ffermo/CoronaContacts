<?php

	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;

	// Contacts: name, email, city, state, zip, phone

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
		// $sql = "select * from Contacts where Name like '%" . $inData["search"] . "%' and UserID=" . $inData["userId"];

		//$sql = "SELECT contact_id, first_name, last_name, email, phone_number, user_id FROM list_of_contacts WHERE (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%') AND user_id = $userId ORDER BY $filter";

		// $sql = "SELECT * FROM Contacts WHERE UserID = ‘$userId’ AND (Name like ‘%$search%’ OR Email like ‘%$search%’ OR City like ‘%$search%’ OR State like ‘%$search%’ OR Zip like ‘%$search%’ OR Phone like ‘%$search%’)";

		// NOTE: Missing ORDER BY $filter"

		// $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "name";

   		// $order = !empty($_GET["order"]) ? $_GET["order"] : "asc";

    	// $sql = "SELECT * FROM countries ORDER BY " . $orderBy . " " . $order;

		// $sql = "select * from Contacts where (Name like '%" . $inData["search"] . "%' or Email like '%" . $inData["search"] . "%' or City like '%" . $inData["search"] . "%' or State like '%" . $inData["search"] . "%' or Zip like '%" . $inData["search"] . "%' or Phone like '%" . $inData["search"] . "%') and UserID =" . $inData["userId"] . "ORDER BY" . $name . "DESC";

		$sql = "select * from Contacts where (Name like '%" . $inData["search"] . "%' or Email like '%" . $inData["search"] . "%' or City like '%" . $inData["search"] . "%' or State like '%" . $inData["search"] . "%' or Zip like '%" . $inData["search"] . "%' or Phone like '%" . $inData["search"] . "%') and UserID =" . $inData["userId"];


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
				// $searchResults .= '"' . $row["Name"] . '"';
				// $searchResults .= '"' . $row["Name"] . '"' .
				//				  '"' . $row["Email"] . '"' .
				//				  '"' . $row["Phone"] . '"';

				$searchResults .= "\r\n" . 'Name: "' . $row["Name"] . '"' . "\n" . 'Email: "' . $row["Email"] . '"' . "\n" . 'Phone: "' . $row["Phone"] . '"';
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>