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

				$searchResults .= '{
				"id":"' . $row["ID"] . '",
				"name":"' . $row["Name"] . '",
				"email":"' . $row["Email"] . '",
				"city":"' . $row["City"] . '",
				"state":"' . $row["State"] . '",
				"zip":"' . $row["Zip"] . '",
				"phoneNumber":"' . $row["Phone"] . '",
				"infected":"' . $row["Infected"] . '",
				"contactId":"'. $row["ID"].'"
				}' ;
				
				// Note for Reference: return all value and we do not have to show them all.
			}

			returnWithInfo( $searchResults );
		}

		else
		{
			$searchResults .= '{
			"contactId": -1
			}';

			returnWithInfo($searchResults);
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css" />
    <title>Dashboard</title>
    <div class="jumbotron">
        <h1 class="display-4">Hello, UserName!</h1>
        <p class="lead">Here at CoronaContact Club, we want you to keep safe by recording a log of your interaction with infected citizens.</p>
        <hr class="my-4">
        <p>Choose any of the options below to manipulate your data... (Pending Update)</p>
        <p class="lead">
          <a class="btn btn-primary btn-lg"  href="#" role="button">Search</a>
          <a class="btn btn-info btn-lg"  href="#" role="button">Add</a>
        </p>
      </div>
</head>
<body>
    
</body>
</html>